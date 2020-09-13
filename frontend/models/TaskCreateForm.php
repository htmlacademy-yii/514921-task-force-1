<?php


namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $location;
    public $latitude;
    public $longitude;
    public $budget;
    public $dateExpire;

    /**
     * @var UploadedFile[]
     */
    public $files = [];


    public function attributeLabels(): array
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'dateExpire' => 'Срок исполнения'
        ];
    }
    public function rules(): array
    {
        return [
            [['name','description','budget'], 'trim'],
            [['name', 'description','category'], 'required'],
            ['name', 'string', 'min' => 10],
            [['location', 'latitude', 'longitude'], 'safe'],
            ['description', 'string', 'min' => 30],
            [['category'], 'exist', 'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => 'id',
                'message' => 'Выбранная категория отсутствует'],
            ['files', 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
            ['budget', 'integer', 'integerOnly' => true, 'min' => '1',
                'message' => 'Поле должно содержать целое положительное число'],
            ['dateExpire', 'date', 'format' => 'php:Y-m-d', 'min' => date('Y-m-d')]
        ];
    }
}
