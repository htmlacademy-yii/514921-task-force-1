<?php


namespace frontend\modules\api\controllers;

use frontend\models\Messages;
use yii\rest\ActiveController;

class MessagesController extends ActiveController
{
    public $modelClass = Messages::class;
}