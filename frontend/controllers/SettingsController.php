<?php

namespace frontend\controllers;

use frontend\models\SettingsForm;
use TaskForce\services\AccountService;
use Yii;
use yii\helpers\Url;

class SettingsController extends SecuredController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $user = Yii::$app->user->getIdentity();
        $form = new SettingsForm();

        $accountService = new AccountService();
        if (\Yii::$app->request->getIsPost()) {
            $accountService->savePictures($user->profiles->id);
            $form->load(\Yii::$app->request->post());
            if ($accountService->editAccount($form)) {
                $this->redirect(Url::to(["/settings"]));
            }
        }
        return $this->render('index', ['model' => $form ,'user' => $user]);
    }
}