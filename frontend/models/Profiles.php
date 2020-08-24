<?php

namespace frontend\models;

use TaskForce\services\EventService;
use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $city_id
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $phone_number
 * @property string|null $skype
 * @property string|null $last_visit
 * @property string|null $telegram
 * @property string|null $avatar
 * @property int|null $message_notifications
 * @property int|null $task_notifications
 * @property int|null $review_notifications
 * @property int|null $hide_contact_info
 * @property int|null $hide_profile
 * @property int|null $views_count
 *
 * @property Cities $city
 * @property Users $user
 * @property UserPictures[] $userPictures
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [[
                'user_id',
                'city_id',
                'message_notifications',
                'task_notifications',
                'review_notifications',
                'hide_contact_info',
                'hide_profile',
                'views_count'
            ], 'integer'],
            [['birthday', 'last_visit'], 'safe'],
            [['about'], 'string'],
            [['phone_number', 'skype'], 'string', 'max' => 45],
            [['telegram', 'avatar'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'city_id' => 'City ID',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone_number' => 'Phone Number',
            'skype' => 'Skype',
            'last_visit' => 'Last Visit',
            'telegram' => 'Telegram',
            'avatar' => 'Avatar',
            'message_notifications' => 'Message Notifications',
            'task_notifications' => 'Task Notifications',
            'review_notifications' => 'Review Notifications',
            'hide_contact_info' => 'Hide Contact Info',
            'hide_profile' => 'Hide Profile',
            'views_count' => 'Views Count',
        ];
    }

    public function subscribedOn($event)
    {
        if (in_array($event['name'], [
            EventService::EVENT_NEW_REPLY,
            EventService::EVENT_START_TASK,
            EventService::EVENT_DECLINE_TASK,
            EventService::EVENT_COMPLETE_TASK,
            ], true)) {
            return $event->user->profiles->task_notifications;
        }
        if ($event['name'] === EventService::EVENT_NEW_MESSAGE) {
            return $event->user->profiles->message_notifications;
        }
        if ($event['name'] === EventService::EVENT_NEW_REVIEW) {
            return $event->user->profiles->review_notifications;
        }
        return false;
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[UserPictures]].
     *
     * @return \yii\db\ActiveQuery|UserPicturesQuery
     */
    public function getUserPictures()
    {
        return $this->hasMany(UserPictures::className(), ['profile_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfilesQuery(get_called_class());
    }
}
