<?php

namespace app\models;


use yii\base\Model;

class UsersFilter extends Model
{
    public $specializations;
    public $freeNow;
    public $onlineNow;
    public $withReviews;
    public $withFavorites;
    public $search;

    public function attributeLabels()
    {
        return [
            'specializations' => 'Категории',
            'freeNow' => 'Сейчас свободен',
            'onlineNow' => 'Сейчас онлайн',
            'withReviews' => 'Есть отзывы',
            'withFavorites' => 'В избранном',
            'search' => 'Поиск по названию'
        ];
    }
    public function rules()
    {
        return [
            [['specializations', 'freeNow', 'onlineNow', 'withReviews', 'withFavorites', 'search'], 'safe']
        ];
    }
}