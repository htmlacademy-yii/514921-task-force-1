<?php

namespace frontend\controllers;

use frontend\models\Events;
use Yii;

class EventsController extends SecuredController
{
    public function actionIndex(): bool
    {
        if (Yii::$app->request->isGet) {
            $currentUser = Yii::$app->user->getIdentity();
            $events = Events::find()->Where(['user_id' => $currentUser->id])
                ->andWhere(['notification_read' => null])->all();
            foreach ($events as $event) {
                $event->notification_read = date('Y-m-d H:i:s');
                $event->save();
            }
            return true;
        }
        return false;
    }
}
