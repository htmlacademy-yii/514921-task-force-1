<?php

namespace app\models;


use yii\base\Model;

class TasksFilter extends Model
{
    public $categories;
    public $noResponse;
    public $remoteWork;
    public $period = [
        'all' => 'За всё время',
        '1 week' => 'За неделю',
        '1 day' => 'За день',
        '1 month' => 'За месяц'
    ];
    public $search;

    public function attributeLabels()
    {
        return [
            'noResponse' => 'Без отликов',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'search' => 'Поиск по названию'
        ];
    }
    public function rules()
    {
        return [
            [['categories', 'noResponse', 'remoteWork','period','search'], 'safe']
        ];
    }

}