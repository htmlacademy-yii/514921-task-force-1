<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "favourite_users".
 *
 * @property int $id
 * @property int $user_id
 * @property int $favorite_user_id
 *
 * @property Users $favoriteUser
 * @property Users $user
 */
class FavouriteUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favourite_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'favorite_user_id'], 'required'],
            [['user_id', 'favorite_user_id'], 'integer'],
            [['favorite_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['favorite_user_id' => 'id']],
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
            'favorite_user_id' => 'Favorite User ID',
        ];
    }

    /**
     * Gets query for [[FavoriteUser]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getFavoriteUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'favorite_user_id']);
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
     * @return FavouriteUsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FavouriteUsersQuery(get_called_class());
    }
}
