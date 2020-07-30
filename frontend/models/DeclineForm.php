<?php


namespace frontend\models;

use TaskForce\models\Task;
use TaskForce\services\EventService;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class DeclineForm extends Model
{
    public function decline($taskId, $replyId)
    {
        $reply = Replies::findOne("$replyId");
        $reply->failed_tasks_count += 1;
        $reply->save();
        $task = Tasks::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $taskId не существует");
        }
        $task->status = Task::STATUS_FAILED;
        $task->save();
        $newEvent = new EventService();
        $newEvent->createEventDeclineTask($task);
        return true;
    }

}