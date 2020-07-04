<?php


namespace TaskForce\services;

use frontend\models\Profiles;
use frontend\models\SettingsForm;
use frontend\models\UserCategories;
use frontend\models\Users;
use TaskForce\MyUploadedFile;
use Yii;

class AccountService
{
    public function editAccount(SettingsForm $form)
    {
        if (!$form->validate()) {
            return null;
        }
        $userId = Yii::$app->user->id;
        $user = Users::findOne($userId);
        $user->name = $form->name;
        $user->email = $form->email;
        $user->city_id = $form->city;
        if ($form->confirmedPassword) {
            $user->setPassword($form->confirmedPassword);
        }
        $user->save();
        if (!empty($form->specializations)) {
            $user->role = 'contractor';
            $user->save();
            $userCategories = UserCategories::deleteAll(['user_id' => "$userId"]);
            foreach ($form->specializations as $specializationId) {
                $updatedCategories = new UserCategories();
                $updatedCategories->user_id = $userId;
                $updatedCategories->category_id = $specializationId;
                $updatedCategories->save();
            }
        } else {
            $userCategories = UserCategories::deleteAll(['user_id' => "$userId"]);
            $user->role = 'customer';
            $user->save();
        }

        $profile = Profiles::findOne(['user_id' => "$userId"]);

        if (!$profile) {
            $newProfile = new Profiles();
            if (property_exists($form->avatar, 'avatar')) {
                $form->avatar = MyUploadedFile::getInstance($form, 'avatar');
                $newProfile->avatar = $form->saveAvatar($form->avatar);
            }
            $newProfile->user_id = $userId;
            $newProfile->city_id = $form->city;
            $newProfile->birthday = $form->birthday;
            $newProfile->about = $form->about;
            $newProfile->skype = $form->skype;
            $newProfile->phone_number = $form->phoneNumber;
            $newProfile->telegram = $form->telegram;
            $newProfile->save();
        } elseif ($profile) {
            if (property_exists($form->avatar, 'avatar')) {
                $form->avatar = MyUploadedFile::getInstance($form, 'avatar');
                $profile->avatar = $form->saveAvatar($form->avatar);
            }
            $profile->city_id = $form->city;
            $profile->birthday = $form->birthday;
            $profile->about = $form->about;
            $profile->skype = $form->skype;
            $profile->phone_number = $form->phoneNumber;
            $profile->telegram = $form->telegram;
            $profile->save();
        }

        return true;
    }

}