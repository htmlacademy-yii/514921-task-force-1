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
    public $budget;
    public $dateExpire;

    /**
     * @var UploadedFile[]
     */
    public $files = [];


    public function attributeLabels()
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
    public function rules()
    {
        return [
            [['name','description','budget'], 'trim'],
            [['name', 'description','category'], 'required'],
            ['name', 'string', 'min' => 10],
            ['description', 'string', 'min' => 30],
            ['files', 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
            ['budget', 'integer', 'integerOnly' => true, 'min' => '1',
                'message' => 'Поле должно содержать целое положительное число'],
            ['dateExpire', 'date', 'min' => date('Y-m-d'), 'format' => 'Y-m-d' ]
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->files as $file) {
                $file->saveAs('uploads/' . md5_file($file->tempName) . '-' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

}