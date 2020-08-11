<?php

namespace TaskForce\helpers;

use yii\helpers\Url;

class UrlHelper
{
    public static function getUserAvatarUrl($user)
    {
        if (!$user->profiles->avatar) {
            return null;
        }
        return Url::to("/uploads/avatars/{$user->profiles->avatar}");
    }

    public static function getTaskUrl($taskId)
    {
        if (!$taskId) {
            return null;
        }
        return Url::to("/task/view/{$taskId}");
    }
}