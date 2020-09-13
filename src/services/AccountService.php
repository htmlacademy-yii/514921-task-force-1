<?php


namespace TaskForce\services;

use frontend\models\Profiles;
use frontend\models\SettingsForm;
use frontend\models\UserCategories;
use frontend\models\UserPictures;
use frontend\models\Users;
use TaskForce\LocalUploadedFile;
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
        $form->avatar = LocalUploadedFile::getInstance($form, 'avatar');
        if ($form->avatar) {
            $profile->avatar = $form->saveAvatar($form->avatar);
        }

        $profile->city_id = $form->city;
        $profile->birthday = $form->birthday;
        $profile->about = $form->about;
        $profile->skype = $form->skype;
        $profile->phone_number = $form->phoneNumber;
        $profile->telegram = $form->telegram;
        $profile->message_notifications = $form->newMessage;
        $profile->task_notifications = $form->taskActions;
        $profile->review_notifications = $form->newReview;
        $profile->hide_contact_info = $form->hideContacts;
        $profile->hide_profile = $form->hideProfile;
        $profile->save();
        return true;
    }

    public function savePictures(SettingsForm $form, $idProfile)
    {
        $userPicturesDir = __DIR__ . '/../../frontend/web/uploads/user-pictures/';
        if (!is_dir($userPicturesDir) && !mkdir($userPicturesDir, 0777, true) && !is_dir($userPicturesDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $userPicturesDir));
        }

        $form->photos = LocalUploadedFile::getInstancesByName('files');
        if (!$form->validate(['photos'])) {
            return $form->getErrors('photos');
        }
        if (!empty($form->photos)) {
            $userPhotos = UserPictures::findAll(['profile_id' => "$idProfile"]);
            foreach ($userPhotos as $picture) {
                 unlink($userPicturesDir . $picture->name);
            }
            $userPhotos = UserPictures::deleteAll(['profile_id' => "$idProfile"]);
            foreach ($form->photos as $photo) {
                $photo->saveAs($userPicturesDir . $photo->getName());
                $userPictures = new UserPictures();
                $userPictures->profile_id = $idProfile;
                $userPictures->name = $photo->getName();
                $userPictures->save();
            }
            return null;
        }


    }
}