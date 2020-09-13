<?php

namespace frontend\modules\api\controllers;

use frontend\models\Messages;
use TaskForce\services\EventService;
use Yii;
use yii\rest\ActiveController;

class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;

    public function actions(): array
    {
        $actions = parent::actions();

        unset($actions['view'], $actions['create']);

        return $actions;
    }

    public function actionCreate(int $id)
    {
        $content = json_decode(Yii::$app->getRequest()->getRawBody());
        $message = new Messages();
        $message->user_id = Yii::$app->user->getId();
        $message->task_id = $id;
        $message->message = $content->message;
        if ($message->save()) {
            $newEvent = new EventService();
            $newEvent->createEventNewMessage($message);
        }
        Yii::$app->getResponse()->setStatusCode(201);
        return $message;
    }

    public function actionView(int $id)
    {
        return Messages::find()->where(['task_id' => $id])->all();
    }

}
