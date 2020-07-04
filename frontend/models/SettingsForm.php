<?php

namespace frontend\models;

use TaskForce\MyUploadedFile;
use Yii;
use yii\base\Model;

class SettingsForm extends Model
{
    public $avatar;
    public $name;
    public $email;
    public $city;
    public $birthday;
    public $about;
    public $specializations;
    public $password;
    public $confirmedPassword;
    public $phoneNumber;
    public $skype;
    public $telegram;

    public function attributeLabels()
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'Email',
            'city' => 'Город',
            'birthday' => 'День рождения',
            'about' => 'Информация о себе',
            'password' => 'Новый пароль',
            'confirmedPassword' => 'Повтор пароля',
            'phoneNumber' => 'Телефон',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
        ];
    }
    public function rules()
    {
        return [
            [['name', 'email', 'about', 'skype', 'telegram'], 'trim'],
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => Users::class,'filter' => function ($query) {
                    $query->andWhere([
                    '!=',
                    'users.email',
                    Yii::$app->user->identity->email,
                    ]);
                }  , 'message' => 'Пользователь с таким email уже существует'],
            ['name', 'unique',
                'targetClass' => Users::class,'filter' => function ($query) {
                    $query->andWhere([
                    '!=',
                    'users.name',
                    Yii::$app->user->identity->name,
                    ]);
                }, 'message' => 'Пользователь с таким именем уже существует'],
            ['avatar', 'image', 'extensions' => 'png, jpg, jpeg',
                'maxWidth' => 1000, 'maxHeight' => 1000],
            [['password', 'confirmedPassword'], 'string', 'min' => 8],
            ['password', 'compare', 'compareAttribute' => 'confirmedPassword'],
            [['specializations'], 'exist', 'skipOnError' => true,
                'targetClass' => Categories::class,
                'targetAttribute' => 'id',
                'allowArray' => true,
                'message' => 'Выбранная категория отсутствует'],
            ['birthday', 'date', 'format' => 'Y-m-d'],
            ['phoneNumber', 'string', 'length' => 8],
            ['skype', 'string', 'min' => 3],
            ['telegram', 'string', 'min' => 1],
            [['city','about'], 'safe'],
        ];
    }
    public function saveAvatar(MyUploadedFile $avatar)
    {
        $avatarDir = __DIR__ . '/../../frontend/web/uploads/';
        if (!is_dir($avatarDir) && !mkdir($avatarDir) && !is_dir($avatarDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $avatarDir));
        }
        $avatar->saveAs($avatarDir . $avatar->getName());
        return $avatar->getName();
    }
}
