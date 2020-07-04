<?php

namespace frontend\controllers;

use frontend\models\SettingsForm;
use TaskForce\services\AccountService;
use Yii;

class SettingsController extends SecuredController
{
    public function actionIndex()
    {
        $user = Yii::$app->user->getIdentity();
        $form = new SettingsForm();
        if (\Yii::$app->request->post()) {
            $form->load(\Yii::$app->request->post());
            $accountService = new AccountService();
            if ($accountService->editAccount($form)) {
                $this->goHome();
            }
        }
        return $this->render('index', ['model' => $form ,'user' => $user]);
    }
}