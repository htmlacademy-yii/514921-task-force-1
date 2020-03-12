<?php


namespace frontend\controllers;


use app\models\Profiles;
use app\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {

        $users = Users::find(['role' => 'ROLE_CUSTOMER'])->addOrderBy(['date_add'=> SORT_DESC])->all();

        return $this->render('index',["users"=>$users]);
    }
}
