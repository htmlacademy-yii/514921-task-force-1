<?php

namespace TaskForce\helpers;

use frontend\models\Users;
use yii\helpers\Url;

class UrlHelper
{
    public static function getUserAvatarUrl(Users $user, string $default = null): string
    {
        if (!$user->profiles->avatar && !$default) {
            return "/img/man-glasses.jpg";
        } elseif ($user->profiles->avatar) {
            return "/uploads/avatars/{$user->profiles->avatar}";
        } else {
            return "/img/{$default}";
        }
    }

    public static function getTaskUrl($taskId): ?string
    {
        if (!$taskId) {
            return null;
        }
        return Url::to("/task/view/{$taskId}");
    }
}