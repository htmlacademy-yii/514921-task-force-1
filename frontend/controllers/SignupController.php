<?php


namespace frontend\controllers;

use frontend\models\SignupForm;
use TaskForce\services\SignUpService;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SignupController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }
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
