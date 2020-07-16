<?php

namespace TaskForce\services;

use frontend\models\Events;
use frontend\models\Tasks;
use Yii;

class EventService
{
    const EVENT_NEW_REPLY = "Новый отклик к заданию";
    const EVENT_START_TASK = "Старт задания";
    const EVENT_DECLINE_TASK = "Отказ от задания исполнителем";
    const EVENT_COMPLETE_TASK = "Завершение задания";
    const EVENT_NEW_MESSAGE = "Новое сообщение в чате";
    const EVENT_NEW_REVIEW = "Новый отзыв";

    public function createEventNewReply(Tasks $task)
    {
        $eventNewReply = new Events();
        $eventNewReply->name = self::EVENT_NEW_REPLY;
        $eventNewReply->user_id = $task->customer_id;
        $eventNewReply->task_id = $task->id;
        $eventNewReply->save();
    }

    public function createEventNewMessage($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventNewMessage = new Events();
        $eventNewMessage->name = self::EVENT_NEW_MESSAGE;
//        $eventNewMessage->user_id = $task->messages;
        $eventNewMessage->task_id = $task->id;
        $eventNewMessage->save();
    }

    public function createEventNewReview($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventNewReview = new Events();
        $eventNewReview->name = self::EVENT_NEW_REVIEW;
//        $eventNewReview->user_id = $task->messages;
        $eventNewReview->task_id = $task->id;
        $eventNewReview->save();
    }

    public function createEventDeclineTask(Tasks $task)
    {
        $eventDeclineTask = new Events();
        $eventDeclineTask->name = self::EVENT_DECLINE_TASK;
        $eventDeclineTask->user_id = $task->customer_id;
        $eventDeclineTask->task_id = $task->id;
        $eventDeclineTask->save();
    }

    public function createEventStartTask(Tasks $task)
    {
        $eventStartTask = new Events();
        $eventStartTask->name = self::EVENT_START_TASK;
        $eventStartTask->user_id = $task->contractor_id;
        $eventStartTask->task_id = $task->id;
        $eventStartTask->save();
    }

    public function createEventCompleteTask(Tasks $task)
    {
        $eventCompleteTask = new Events();
        $eventCompleteTask->name = self::EVENT_COMPLETE_TASK;
        $eventCompleteTask->user_id = $task->contractor_id;
        $eventCompleteTask->task_id = $task->id;
        $eventCompleteTask->save();
    }

    public function sendEmailNewReply($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'newReply-html'],
                ['data' => $emailContent]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }

    public function sendEmailDeclineTask($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'taskDecline-html'],
                ['data' => $emailContent]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }

    public function sendEmailStartTask($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'taskStart-html'],
                ['data' => $emailContent]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }

    public function sendEmailCompleteTask($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'taskComplete-html'],
                ['data' => $emailContent]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }

    public function sendEmailNewMessage($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'newMessage-html'],
                ['data' => $emailContent]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }

    public function sendEmailNewReview($emailContent)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'newReview-html'],
                ['data' => $emailContent->user]
            )
            ->setTo($emailContent->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject($emailContent->name)
            ->send();
    }
}