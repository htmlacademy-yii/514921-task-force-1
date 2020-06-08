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
    }

    public function actionView($id)
    {
        $messages = Messages::find()->where(['task_id' => $id])->all();
        $response_data = [];
        foreach ($messages as $message) {
            $response_data[] = [
                'message' => $message->message,
                'published_at' => $message->published_at,
                'is_mine' => $message->user_id === Yii::$app->user->getId(),
            ];
        }

        return $response_data;
    }

}