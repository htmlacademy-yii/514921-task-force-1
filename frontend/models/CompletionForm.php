<?php


namespace frontend\models;


use yii\base\Model;

class CompletionForm extends Model
{
    public $isComplete;
    public $review;
    public $rating;

    public function attributeLabels()
    {
        return [
            'isComplete' => 'Задание выполнено?',
            'review' => 'Комментарий',
            'rating' => 'Оценка',
        ];
    }

    public function rules()
    {
        return [
            [['isComplete'], 'required', 'message' => 'Укажите выполнено ли задание'],
            ['review', 'trim'],
            ['review', 'string', 'max' => 255],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
        ];
    }
}
