<?php


namespace TaskForce\services;

use frontend\models\Attachments;
use frontend\models\TaskCreateForm;
use frontend\models\Tasks;
use TaskForce\MyUploadedFile;
use Yii;

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
        return true;
    }
}
