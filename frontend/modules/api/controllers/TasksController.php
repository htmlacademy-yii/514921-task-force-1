<?php

namespace frontend\modules\api\controllers;

use frontend\models\Tasks;
use Yii;
use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index']);

        return $actions;
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()->where(['contractor_id' => $userId->id])->all();
        $response_data = [];
        foreach ($tasks as $task) {
            $response_data[] = [
                'title' => $task->name,
                'published_at' => $task->date_add,
                'new_messages' => $task->getMessages()->count(),
                'author_name' =>  $task->customer->name,
                'id' => $task->id,
            ];
        }

        return $response_data;
    }
}