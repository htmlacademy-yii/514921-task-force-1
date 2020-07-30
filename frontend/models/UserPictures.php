<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_pictures".
 *
 * @property int $id
 * @property int $profile_id
 * @property string $name
 *
 * @property Profiles $profile
 */
class UserPictures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_pictures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'name'], 'required'],
            [['profile_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery|ProfilesQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserPicturesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserPicturesQuery(get_called_class());
    }
}
