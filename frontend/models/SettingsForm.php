<?php

namespace frontend\models;

use TaskForce\LocalUploadedFile;
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
    public $newMessage;
    public $taskActions;
    public $newReview;
    public $hideContacts;
    public $hideProfile;

    public $photos = [];

    public function attributeLabels(): array
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
            'newMessage' => 'Новое сообщение',
            'taskActions' => 'Действия по заданию',
            'newReview' => 'Новый отзыв',
            'hideContacts' => 'Показывать мои контакты только заказчику',
            'hideProfile' => 'Не показывать мой профиль',
        ];
    }
    public function rules(): array
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
            ['photos', 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg',
                'maxWidth' => 1000, 'maxHeight' => 1000, 'maxFiles' => 6],
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
            [[
                'newMessage',
                'taskActions',
                'newReview',
                'hideContacts',
                'hideProfile',
            ], 'boolean', 'trueValue' => true, 'strict' => false],
        ];
    }
    public function saveAvatar(LocalUploadedFile $avatar): string
    {
        $avatarDir = __DIR__ . '/../../frontend/web/uploads/avatars/';
        if (!is_dir($avatarDir) && !mkdir($avatarDir) && !is_dir($avatarDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $avatarDir));
        }
        $avatar->saveAs($avatarDir . $avatar->getName());
        return $avatar->getName();
    }
}
