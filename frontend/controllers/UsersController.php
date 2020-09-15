<?php


namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Users;
use frontend\models\UsersFilter;
use TaskForce\models\Task;
use TaskForce\services\FilterService;
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

        $usersFilter = new UsersFilter();
        $usersFilter->load(\Yii::$app->request->get());
        $filter = new FilterService();

        $dataProvider = new ActiveDataProvider([
            'query' => $filter->applyUsersFilter($usersFilter, $query),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => $sort,
        ]);

        $categoriesDataProvider = new ActiveDataProvider([
            'models' => Categories::find()->select('name')->indexBy('id')->column(),
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider,
            "usersFilter" => $usersFilter, 'sort' => $sort, 'categories' => $categoriesDataProvider]);
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
