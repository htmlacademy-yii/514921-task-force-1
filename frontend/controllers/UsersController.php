<?php


namespace frontend\controllers;

use frontend\models\FavouriteUsers;
use frontend\models\Users;
use frontend\models\UsersFilter;
use TaskForce\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use Yii;
use yii\web\NotFoundHttpException;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $query = Users::find()->where(['role' => Task::ROLE_CONTRACTOR])->joinWith('profiles')
            ->andWhere(['hide_profile' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['date_add' => SORT_DESC]],
        ]);

        $usersFilter = new UsersFilter();
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
        if ($usersFilter->search) {
            $query->andWhere(['LIKE', 'users.name', $usersFilter->search]);
        }

        return $this->render('index', ['dataProvider' => $dataProvider, "usersFilter" => $usersFilter]);
    }
    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не существует");
        } elseif (!($user->role === Task::ROLE_CONTRACTOR)) {
            throw new HttpException(404);
        }
        return $this->render('view', ['user' => $user]);
    }
    public function actionAddfavourite($id)
    {
        $currentUser = Yii::$app->user->getIdentity();
        if ((int)$currentUser->getId() === (int)$id) {
            Yii::$app->session->setFlash('info', "Это ваш профиль");
            return $this->redirect(Yii::$app->request->referrer);
        }

        $favouriteUser = FavouriteUsers::find()->where(['and',
            ['user_id' => $currentUser->getId()],
            ['favorite_user_id' => $id]
        ])->one();
        if (isset($favouriteUser)) {
            Yii::$app->session->setFlash('error', "Пользователь уже добавлен в избранное");
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $newFavouriteUser = new FavouriteUsers();
            $newFavouriteUser->user_id = $currentUser->id;
            $newFavouriteUser->favorite_user_id = $id;
            $newFavouriteUser->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
