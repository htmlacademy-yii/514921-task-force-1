<?php

namespace console\controllers;

use frontend\models\Events;
use LogicException;
use TaskForce\services\EventService;
use Yii;
use yii\console\Controller;

class NotificationController extends Controller
{
    public function actionSend()
    {
        $events = Events::findAll(['email_sent' => null]);
        $eventService = new EventService();
        foreach ($events as $event) {
            if (!$event->user->profiles->subscribedOn($event)) {
                $event->email_sent = date('Y-m-d H:i:s');
                $event->save();
                continue;
            }
            switch ($event['name']) {
                case EventService::EVENT_NEW_REPLY:
                    $eventService->sendEmailNewReply($event);
                    break;
                case EventService::EVENT_START_TASK:
                    $eventService->sendEmailStartTask($event);
                    break;
                case EventService::EVENT_DECLINE_TASK:
                    $eventService->sendEmailDeclineTask($event);
                    break;
                case EventService::EVENT_COMPLETE_TASK:
                    $eventService->sendEmailCompleteTask($event);
                    break;
                case EventService::EVENT_NEW_MESSAGE:
                    $eventService->sendEmailNewMessage($event);
                    break;
                case EventService::EVENT_NEW_REVIEW:
                    $eventService->sendEmailNewReview($event);
                    break;

                default:
                    throw new LogicException('Неизвестный тип события');
            }
            $event->email_sent = date('Y-m-d H:i:s');
            $event->save();
        }
    }
}