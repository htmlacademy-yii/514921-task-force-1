<?php

namespace frontend\modules\api\controllers;

use frontend\models\Messages;
use Yii;
use yii\rest\ActiveController;

class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['view'], $actions['create']);

        return $actions;
    }

    public function actionCreate($id)
    {
        $content = json_decode(Yii::$app->getRequest()->getRawBody());
        $message = new Messages();
        $message->user_id = Yii::$app->user->getId();
        $message->task_id = $id;
        $message->message = $content->message;
        $message->save();

        Yii::$app->getResponse()->setStatusCode(201);
        return $this->asJson($message);
    }

    public function actionView($id)
    {
        return Messages::find()->where(['task_id' => $id])->all();
    }

}