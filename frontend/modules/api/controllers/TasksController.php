<?php

namespace frontend\modules\api\controllers;

use frontend\models\Tasks;
use Yii;
use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = Tasks::class;

    public function actions(): array
    {
        $actions = parent::actions();

        unset($actions['index']);

        return $actions;
    }

    public function actionIndex(): array
    {
        $userId = Yii::$app->user->getIdentity();
        return Tasks::find()->where(['contractor_id' => $userId->id])->all();
    }
}