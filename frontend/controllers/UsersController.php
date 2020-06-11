<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\UsersFilter;
use TaskForce\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use Yii;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $query = Users::find()->where(['role' => Task::ROLE_CONTRACTOR]);

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
            ->andWhere(['contractor_id' => NULL]);
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
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
