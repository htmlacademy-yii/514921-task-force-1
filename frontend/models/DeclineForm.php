<?php


namespace frontend\models;

use TaskForce\models\Task;
use yii\base\Model;
use yii\helpers\Url;

class DeclineForm extends Model
{
    public function decline($taskId, $replyId)
    {
        $reply = Replies::findOne("$replyId");
        $reply->failed_tasks_count += 1;
        $reply->save();
        $task = Tasks::findOne($taskId);
        $task->status = Task::STATUS_FAILED;
        return $task->save();
    }

}