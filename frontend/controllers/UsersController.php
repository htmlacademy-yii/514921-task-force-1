<?php


namespace frontend\controllers;


use app\models\Users;
use app\models\UsersFilter;
use TaskForce\models\Task;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $query = Users::find()->where(['role' => Task::ROLE_CONTRACTOR]);

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

        $users = $query->addOrderBy(['date_add'=> SORT_DESC])->all();
        return $this->render('index',["users"=>$users, "usersFilter" => $usersFilter]);
    }
    public function actionView($id)
    {
        $user = Users::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с id $id не существует");
        }
        return $this->render('view',['user' => $user]);
    }
}
