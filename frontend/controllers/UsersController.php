<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\UsersFilter;
use TaskForce\models\Task;
use TaskForce\services\ProfileService;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\HttpException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UsersController extends SecuredController
{
    public function actionIndex(): string
    {
        $query = Users::find()->where(['role' => Task::ROLE_CONTRACTOR])->joinWith('profiles')
            ->andWhere(['hide_profile' => null])->joinWith('reviews')->groupBy('users.id');
        $sort = new Sort([
            'defaultOrder' => [
                'date_add' => SORT_DESC,
            ],
            'attributes' => [
                'date_add',
                'rating' => [
                    'desc' => ['avg(reviews.rating)' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Рейтингу',
                ],
                'task_completion_status' => [
                    'desc' => ['sum(reviews.task_completion_status ="yes")' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Числу заказов',
                ],
                'views_count' => [
                    'asc' => ['profiles.views_count' => SORT_ASC],
                    'desc' => ['profiles.views_count' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Популярности',
                ],
            ],
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => $sort,
        ]);

        $usersFilter = new UsersFilter();
        $currentUser = Yii::$app->user->getIdentity();
        $usersFilter->load(\Yii::$app->request->get());
        if ($usersFilter->specializations) {
            $query->joinWith('userCategories')
            ->andWhere(['category_id' => $usersFilter->specializations]);
        }
        if ($usersFilter->freeNow) {
            $query->joinWith('tasks')
            ->andWhere(['contractor_id' => null]);
        }
        if ($usersFilter->onlineNow) {
            $query->joinWith('profiles')
            ->andWhere(['>', 'profiles.last_visit', date("Y-m-d H:i:s", strtotime("- 30 minutes"))]);
        }
        if ($usersFilter->withReviews) {
            $query->joinWith('reviews')
            ->andWhere(['not', ['reviews.user_id' => null]]);
        }
        if ($usersFilter->withFavorites) {
            $query->joinWith('favouriteUsers')
                ->onCondition(['favourite_users.user_id' => $currentUser->getId()]);
        }
        if ($usersFilter->search) {
            $query->andWhere(['LIKE', 'users.name', $usersFilter->search]);
        }

        return $this->render('index', ['dataProvider' => $dataProvider,
            "usersFilter" => $usersFilter, 'sort' => $sort]);
    }

    public function actionView(int $id): string
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не существует");
        } elseif (!($user->role === Task::ROLE_CONTRACTOR)) {
            throw new HttpException(404);
        }
        $viewCounter = new ProfileService();
        $viewCounter->addViewCount($id);
        return $this->render('view', ['user' => $user]);
    }

    public function actionAddfavourite(int $id)
    {
        $favouriteUser = new ProfileService();
        $favouriteUser->addFavouriteUser($id);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
