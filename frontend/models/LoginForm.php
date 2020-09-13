<?php

namespace frontend\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    public function attributeLabels(): array
    {
        return [
            'password' => 'Пароль',
            'email' => 'Email',
        ];
    }
    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => Users::class,
                'targetAttribute' => 'email',
                'message' => 'Пользователя с таким email не существует'],
            [['email', 'password'], 'safe'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Вы ввели неверный пароль');
            }
        }
    }

    public function getUser(): Users
    {
        if ($this->_user === null) {
            $this->_user = Users::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}