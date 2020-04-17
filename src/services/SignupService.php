<?php

namespace TaskForce\services;

use app\models\Users;
use frontend\models\SignupForm;

class SignUpService
{
    public function signUp(SignupForm $form)
    {
        if (!$form->validate()) {
            return null;
        }
        $user = new Users();
        $user->email = $form->email;
        $user->name = $form->username;
        $user->setPassword($form->password);
        $user->city_id = $form->city;

        return $user->save();
    }
}
