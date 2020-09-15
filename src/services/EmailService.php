<?php

namespace TaskForce\services;

use Yii;

class EmailService
{
    public function sendEmailNewReply($emailContent): bool
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

    public function sendEmailDeclineTask($emailContent): bool
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

    public function sendEmailStartTask($emailContent): bool
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

    public function sendEmailCompleteTask($emailContent): bool
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

    public function sendEmailNewMessage($emailContent): bool
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

    public function sendEmailNewReview($emailContent): bool
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
