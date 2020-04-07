<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $city_id
 * @property string|null $address
 * @property string|null $birthday
 * @property string|null $about
 * @property string|null $phone_number
 * @property string|null $skype
 * @property string|null $last_visit
 *
 * @property Cities $city
 * @property Users $user
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
            [['user_id', 'city_id'], 'integer'],
            [['birthday', 'last_visit'], 'safe'],
            [['about'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['phone_number', 'skype'], 'string', 'max' => 45],
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
            'address' => 'Address',
            'birthday' => 'Birthday',
            'about' => 'About',
            'phone_number' => 'Phone Number',
            'skype' => 'Skype',
            'last_visit' => 'Last Visit',
        ];
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
     * {@inheritdoc}
     * @return ProfilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfilesQuery(get_called_class());
    }
}
