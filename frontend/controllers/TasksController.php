<?php


namespace frontend\controllers;


use app\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find(['status' => 'STATUS_NEW'])->addOrderBy(['date_add'=> SORT_DESC])->all();
        return $this->render('index', ["tasks"=>$tasks]);
    }
}