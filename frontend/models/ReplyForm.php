<?php

namespace frontend\models;

use yii\base\Model;

class ReplyForm extends Model
{
    public $price;
    public $comment;

    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий',
        ];
    }

    public function rules()
    {
        return [
            [['price','comment'], 'trim'],
            ['price', 'integer', 'integerOnly' => true, 'min' => '1',
                'message' => 'Поле должно содержать целое положительное число'],
        ];
    }
}
