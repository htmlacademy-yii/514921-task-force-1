<?php

namespace frontend\controllers;

use frontend\models\SettingsForm;
use TaskForce\services\AccountService;
use Yii;
use yii\helpers\Url;

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
                $this->redirect(Url::to(["/settings"]));
            }
        }
        return $this->render('index', ['model' => $form ,'user' => $user]);
    }
}