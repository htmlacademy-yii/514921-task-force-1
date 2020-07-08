<?php

namespace TaskForce\services;

use frontend\models\Events;
use frontend\models\Tasks;

class EventService
{
    public function createEventNewReply($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventNewReply = new Events();
        $eventNewReply->name = "Новый отклик к заданию";
        $eventNewReply->user_id = $task->customer_id;
        $eventNewReply->task_id = $task->id;
        $eventNewReply->save();
    }

    public function createEventNewMessage($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventNewMessage = new Events();
        $eventNewMessage->name = "Новое сообщение в чате";
//        $eventNewMessage->user_id = $task->messages;
        $eventNewMessage->task_id = $task->id;
        $eventNewMessage->save();
    }

    public function createEventDeclineTask($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventDeclineTask = new Events();
        $eventDeclineTask->name = "Отказ от задания исполнителем";
        $eventDeclineTask->user_id = $task->customer_id;
        $eventDeclineTask->task_id = $task->id;
        $eventDeclineTask->save();
    }

    public function createEventStartTask($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventStartTask = new Events();
        $eventStartTask->name = "Старт задания";
        $eventStartTask->user_id = $task->contractor_id;
        $eventStartTask->task_id = $task->id;
        $eventStartTask->save();
    }

    public function createEventCompleteTask($taskId)
    {
        $task = Tasks::findOne($taskId);
        $eventCompleteTask = new Events();
        $eventCompleteTask->name = "Завершение задания";
        $eventCompleteTask->user_id = $task->contractor_id;
        $eventCompleteTask->task_id = $task->id;
        $eventCompleteTask->save();
    }
}