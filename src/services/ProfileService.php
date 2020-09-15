<?php


namespace TaskForce\services;

use frontend\models\FavouriteUsers;
use frontend\models\Profiles;
use Yii;

class ProfileService
{
    public function addFavouriteUser(int $userId): bool
    {
        $currentUser = Yii::$app->user->getIdentity();
        if ((int)$currentUser->getId() === (int)$userId) {
            Yii::$app->session->setFlash('info', "Это ваш профиль");
            return true;
        }

        $favouriteUser = FavouriteUsers::find()->where(['and',
            ['user_id' => $currentUser->getId()],
            ['favorite_user_id' => $userId]
        ])->one();
        if (isset($favouriteUser)) {
            Yii::$app->session->setFlash('error', "Пользователь уже добавлен в избранное");
            return false;
        } else {
            $newFavouriteUser = new FavouriteUsers();
            $newFavouriteUser->user_id = $currentUser->id;
            $newFavouriteUser->favorite_user_id = $userId;
            $newFavouriteUser->save();
            return true;
        }
    }

    public function addViewCount(int $userId): ?bool
    {
        $currentUser = Yii::$app->user->getIdentity();
        if ((int)$currentUser->getId() === (int)$userId) {
            return null;
        } else {
            $userProfile = Profiles::findOne(['user_id' => $userId]);
            $userProfile->views_count += 1;
            $userProfile->save();
            return true;
        }
    }
}
