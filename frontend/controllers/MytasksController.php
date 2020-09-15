<?php

namespace frontend\controllers;

use frontend\models\Tasks;
use TaskForce\models\Task;
use Yii;

class MytasksController extends SecuredController
{
    public function actionNew(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()
            ->Where(['customer_id' => $currentUser->id])
            ->orWhere(['contractor_id' => $currentUser->id])
            ->andWhere(['status' => Task::STATUS_NEW])
            ->all();
        return $this->render('index', ['tasks' => $tasks, 'status' => Task::STATUS_NEW]);
    }

    public function actionInprogress(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()
            ->Where(['customer_id' => $currentUser->id])
            ->orWhere(['contractor_id' => $currentUser->id])
            ->andWhere(['status' => Task::STATUS_IN_PROGRESS])
            ->all();
        return $this->render('index', ['tasks' => $tasks, 'status' => Task::STATUS_IN_PROGRESS]);
    }

    public function actionCompleted(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()
            ->Where(['customer_id' => $currentUser->id])
            ->orWhere(['contractor_id' => $currentUser->id])
            ->andWhere(['status' => Task::STATUS_COMPLETED])
            ->all();
        return $this->render('index', ['tasks' => $tasks, 'status' => Task::STATUS_COMPLETED]);
    }

    public function actionCanceled(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()
            ->Where(['customer_id' => $currentUser->id])
            ->andWhere('status = :canceled OR status = :failed', [
                ':canceled' => Task::STATUS_CANCELED,
                ':failed' => Task::STATUS_FAILED ])
            ->orWhere('contractor_id = :contractor AND status = :failed', [
                ':contractor' => $currentUser->id,
                ':failed' => Task::STATUS_FAILED ])
            ->all();
        return $this->render('index', ['tasks' => $tasks, 'status' => Task::STATUS_CANCELED]);
    }

    public function actionExpired(): string
    {
        $currentUser = Yii::$app->user->getIdentity();
        $tasks = Tasks::find()
            ->Where(['customer_id' => $currentUser->id])
            ->orWhere(['contractor_id' => $currentUser->id])
            ->andWhere(['status' => Task::STATUS_IN_PROGRESS])
            ->andWhere(['<', 'date_expire', date('Y-m-d 00:00:00')])
            ->all();
        return $this->render('index', ['tasks' => $tasks, 'status' => Task::STATUS_EXPIRED]);
    }
}
