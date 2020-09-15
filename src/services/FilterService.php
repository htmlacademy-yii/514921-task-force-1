<?php


namespace TaskForce\services;

use frontend\models\TasksFilter;
use frontend\models\UsersFilter;
use TaskForce\models\Task;
use Yii;
use yii\db\ActiveQuery;

class FilterService
{
    public function applyCategoriesFilter(TasksFilter $filter, ActiveQuery $query)
    {
        if ($filter->categories) {
            $query->andWhere(['category_id' => $filter->categories]);
        }
        if ($filter->noResponse) {
            $query->joinWith('replies')
                ->andWhere(['replies.user_id' => null]);
        }
        if ($filter->remoteWork) {
            $query->andWhere(['and',['city_id' => null],['status' => Task::STATUS_NEW]]);
        }
        if ($filter->search) {
            $query->andWhere(['LIKE', 'tasks.name', $filter->search]);
        }
        switch ($filter->period) {
            case '1 day':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 day"))]);
                break;
            case '1 week':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 week"))]);
                break;
            case '1 month':
                $query->andWhere(['>', 'tasks.date_add', date("Y-m-d H:i:s", strtotime("- 1 month"))]);
                break;
        }
        return $query;
    }

    public function applyUsersFilter(UsersFilter $usersFilter, ActiveQuery $query)
    {
        $currentUser = Yii::$app->user->getIdentity();

        if ($usersFilter->specializations) {
            $query->joinWith('userCategories')
                ->andWhere(['category_id' => $usersFilter->specializations]);
        }
        if ($usersFilter->freeNow) {
            $query->joinWith('tasks')
                ->andWhere(['contractor_id' => null]);
        }
        if ($usersFilter->onlineNow) {
            $query->joinWith('profiles')
                ->andWhere(['>', 'profiles.last_visit', date("Y-m-d H:i:s", strtotime("- 30 minutes"))]);
        }
        if ($usersFilter->withReviews) {
            $query->joinWith('reviews')
                ->andWhere(['not', ['reviews.user_id' => null]]);
        }
        if ($usersFilter->withFavorites) {
            $query->joinWith('favouriteUsers')
                ->onCondition(['favourite_users.user_id' => $currentUser->getId()]);
        }
        if ($usersFilter->search) {
            $query->andWhere(['LIKE', 'users.name', $usersFilter->search]);
        }

        return $query;
    }
}
