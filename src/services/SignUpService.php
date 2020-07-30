<?php

namespace TaskForce\services;

use frontend\models\Profiles;
use frontend\models\Users;
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
        $user->save();
        $newProfile = new Profiles();
        $newProfile->user_id = $user->id;
        $newProfile->city_id = $user->city_id;
        return $newProfile->save();
    }
}
