<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Tasks;
use TaskForce\models\Task;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LandingController extends Controller
{

    public function actionIndex()
    {
        $this->layout = 'landing';
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/tasks']);
        }

        $tasks = Tasks::find()->orderBy("id desc")->where(['status' => Task::STATUS_NEW])->limit(4)->all();

        $loginForm = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['/tasks']);
            }
        }
        return $this->render('index', ['model' => $loginForm, 'tasks' => $tasks]);
    }
}
