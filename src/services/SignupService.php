<?php

namespace TaskForce\services;

use app\models\Users;

class SignUpService
{
    public function signUp($form)
    {
        $user = new Users();
        $user->email = $form->email;
        $user->name = $form->username;
        $user->setPassword($form->password);
        $user->city_id = $form->city;

        return $user->save();
    }
}
