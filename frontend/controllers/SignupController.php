<?php


namespace frontend\controllers;

use frontend\models\SignupForm;
use TaskForce\services\SignUpService;
use yii\web\Controller;
use Yii;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $form = new SignupForm();

        if (Yii::$app->request->post()) {
            $form->load(Yii::$app->request->post());
            $signUpService = new SignUpService();
            if ($signUpService->signUp($form)) {
                $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $form,
        ]);
    }
}
