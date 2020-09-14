<?php

namespace console\controllers;

use frontend\models\Events;
use LogicException;
use TaskForce\services\EmailService;
use TaskForce\services\EventService;
use yii\console\Controller;

class NotificationController extends Controller
{
    public function actionSend(): void
    {
        $events = Events::findAll(['email_sent' => null]);
        $emailService = new EmailService();
        foreach ($events as $event) {
            if (!$event->user->profiles->subscribedOn($event)) {
                $event->email_sent = date('Y-m-d H:i:s');
                $event->save();
                continue;
            }
            switch ($event['name']) {
                case EventService::EVENT_NEW_REPLY:
                    $emailService->sendEmailNewReply($event);
                    break;
                case EventService::EVENT_START_TASK:
                    $emailService->sendEmailStartTask($event);
                    break;
                case EventService::EVENT_DECLINE_TASK:
                    $emailService->sendEmailDeclineTask($event);
                    break;
                case EventService::EVENT_COMPLETE_TASK:
                    $emailService->sendEmailCompleteTask($event);
                    break;
                case EventService::EVENT_NEW_MESSAGE:
                    $emailService->sendEmailNewMessage($event);
                    break;
                case EventService::EVENT_NEW_REVIEW:
                    $emailService->sendEmailNewReview($event);
                    break;

                default:
                    throw new LogicException('Неизвестный тип события');
            }
            $event->email_sent = date('Y-m-d H:i:s');
            $event->save();
        }
    }
}
