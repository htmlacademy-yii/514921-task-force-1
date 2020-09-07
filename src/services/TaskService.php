<?php


namespace TaskForce\services;

use frontend\models\Attachments;
use frontend\models\CompletionForm;
use frontend\models\Replies;
use frontend\models\ReplyForm;
use frontend\models\Reviews;
use frontend\models\TaskCreateForm;
use frontend\models\Tasks;
use TaskForce\models\Task;
use TaskForce\MyUploadedFile;
use Yii;
use yii\web\NotFoundHttpException;

class TaskService
{
    public function createTask(TaskCreateForm $form)
    {
        if (!$form->validate()) {
            return null;
        }
        $customer = Yii::$app->user->getIdentity();
        $task = new Tasks();
        $task->name = $form->name;
        $task->description = $form->description;
        $task->category_id = $form->category;
        $task->budget = $form->budget;
        $task->date_expire = $form->dateExpire;
        $task->date_add = date('Y-m-d H:i:s');
        $task->customer_id = $customer->id;
        $longitude = $form->longitude;
        $latitude = $form->latitude;
        if (!empty($form->location) && !empty($longitude) && !empty($latitude)) {
            $task->city_id = $customer->city_id;
            $task->address = $form->location;
            $task->coordinates = $longitude . " " .  $latitude;
        }
        $task->save();
        $idTask = $task->id;
        $form->files = MyUploadedFile::getInstances($form, 'files');
        $uploadsDir = __DIR__ . '/../../frontend/web/uploads/';
        if (!is_dir($uploadsDir) && !mkdir($uploadsDir) && !is_dir($uploadsDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadsDir));
        }
        foreach ($form->files as $file) {
            /** Сохранение загруженных файлов в папку проекта uploads */
            $file->saveAs($uploadsDir . $file->getName());

            /** Сохранение имени файла и id задания в БД */
            $taskFiles = new Attachments();
            $taskFiles->task_id = $idTask;
            $taskFiles->name = $file->getName();
            $taskFiles->save();
        }
        return $task->id;
    }
    public function createReply(ReplyForm $form, $taskId)
    {
        if (!$form->validate()) {
            return null;
        }
        $task = Tasks::findOne($taskId);
        $reply = new Replies();
        $reply->task_id = $taskId;
        $reply->user_id = Yii::$app->user->id;
        $reply->description = $form->comment;
        $reply->price = $form->price;
        $reply->date_add = date('Y-m-d H:i:s');
        $reply->save();
        $newEvent = new EventService();
        $newEvent->createEventNewReply($task);
        return true;
    }

    public function completeTask(CompletionForm $form, $taskId)
    {
        if (!$form->validate()) {
            return null;
        }
        $task = Tasks::findOne($taskId);
        if (!$task) {
            throw new NotFoundHttpException("Задания с id $taskId не существует");
        }
        $review = new Reviews();
        $task->status = $form->isComplete === 'yes' ? Task::STATUS_COMPLETED : Task::STATUS_FAILED;
        $task->save();
        $newEvent = new EventService();
        $newEvent->createEventCompleteTask($task);
        if (!empty($form->review)) {
            $newEvent->createEventNewReview($task);
        }
        $review->task_id = $taskId;
        $review->user_id = $task->contractor_id;
        $review->review = $form->review;
        $review->rating = $form->rating;
        $review->task_completion_status = $form->isComplete === 'yes' ? 'yes' : 'no';

        return $review->save();
    }

}
