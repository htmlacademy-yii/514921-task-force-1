<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecuredController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action): bool
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $user->profiles->last_visit = date('Y-m-d H:i:s');
            $user->profiles->save();
        }
        return parent::beforeAction($action);
    }
}
