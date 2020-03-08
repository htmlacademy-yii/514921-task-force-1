<?php


namespace frontend\controllers;


use app\models\Profiles;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
     //   $users = Tasks::find()->addOrderBy(['date_add'=> SORT_ASC])->all();
        $users = Profiles::find()->all();
//        foreach ($users as $user) {
//            $user->
//        }
        return $this->render('index',["users"=>$users]);
    }
}