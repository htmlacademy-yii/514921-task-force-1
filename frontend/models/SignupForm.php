<?php


namespace frontend\models;

use app\models\Users;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $city;


    public function attributeLabels()
    {
        return [
            'username' => 'Ваше имя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'city' => 'Город проживания'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'city'], 'safe'],
            [['username','email'], 'trim'],
            [['email', 'password','username'], 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique',
                'targetClass' => Users::class, 'message' => 'Пользователь с таким email уже существует'],
            ['password', 'string', 'min' => 8],
            ['city', 'safe'],
        ];
    }
}
