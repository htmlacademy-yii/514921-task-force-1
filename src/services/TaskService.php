<?php


namespace TaskForce\services;

use frontend\models\Attachments;
use frontend\models\TaskCreateForm;
use frontend\models\Tasks;
use Yii;
use yii\web\UploadedFile;

class TaskService
{
    public function createTask(TaskCreateForm $form)
    {
        if (!$form->validate()) {
            return null;
        }
        $task = new Tasks();
        $task->name = $form->name;
        $task->description = $form->description;
        $task->category_id = $form->category;
        $task->budget = $form->budget;
        $task->date_expire = $form->dateExpire;
        $task->customer_id = Yii::$app->user->id;
        $task->save();
        $idTask = $task->id;
        $taskFiles = new Attachments();
        $form->files = UploadedFile::getInstances($form, 'files');
        if ($form->upload()) {
            foreach ($form->files as $file) {
                $taskFiles->task_id = $idTask;
                $taskFiles->name = $file->tempName . '-' . $file->baseName . '.' . $file->extension;
                $taskFiles->save();
            }
            return true;
        }






    }

}