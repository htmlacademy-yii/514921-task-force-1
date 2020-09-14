<?php

namespace TaskForce\services;

use frontend\models\Events;
use frontend\models\Messages;
use frontend\models\Tasks;

class EventService
{
    const EVENT_NEW_REPLY = "Новый отклик к заданию";
    const EVENT_START_TASK = "Старт задания";
    const EVENT_DECLINE_TASK = "Отказ от задания исполнителем";
    const EVENT_COMPLETE_TASK = "Завершение задания";
    const EVENT_NEW_MESSAGE = "Новое сообщение в чате";
    const EVENT_NEW_REVIEW = "Новый отзыв";

    public function createEventNewReply(Tasks $task): void
    {
        $eventNewReply = new Events();
        $eventNewReply->name = self::EVENT_NEW_REPLY;
        $eventNewReply->user_id = $task->customer_id;
        $eventNewReply->task_id = $task->id;
        $eventNewReply->save();
    }

    public function createEventNewMessage(Messages $message): void
    {
        $task = Tasks::findOne($message->task_id);
        $eventNewMessage = new Events();
        $eventNewMessage->name = self::EVENT_NEW_MESSAGE;
        $eventNewMessage->user_id = $message->user_id === $task->contractor_id
            ? $task->customer_id : $task->contractor_id;
        $eventNewMessage->task_id = $message->task_id;
        $eventNewMessage->save();
    }

    public function createEventNewReview(Tasks $task): void
    {
        $eventNewReview = new Events();
        $eventNewReview->name = self::EVENT_NEW_REVIEW;
        $eventNewReview->user_id = $task->contractor_id;
        $eventNewReview->task_id = $task->id;
        $eventNewReview->save();
    }

    public function createEventDeclineTask(Tasks $task): void
    {
        $eventDeclineTask = new Events();
        $eventDeclineTask->name = self::EVENT_DECLINE_TASK;
        $eventDeclineTask->user_id = $task->customer_id;
        $eventDeclineTask->task_id = $task->id;
        $eventDeclineTask->save();
    }

    public function createEventStartTask(Tasks $task): void
    {
        $eventStartTask = new Events();
        $eventStartTask->name = self::EVENT_START_TASK;
        $eventStartTask->user_id = $task->contractor_id;
        $eventStartTask->task_id = $task->id;
        $eventStartTask->save();
    }

    public function createEventCompleteTask(Tasks $task): void
    {
        $eventCompleteTask = new Events();
        $eventCompleteTask->name = self::EVENT_COMPLETE_TASK;
        $eventCompleteTask->user_id = $task->contractor_id;
        $eventCompleteTask->task_id = $task->id;
        $eventCompleteTask->save();
    }
}
