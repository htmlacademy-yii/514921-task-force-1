<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $name
 * @property int $city_id
 * @property string|null $password
 * @property string|null $date_add
 * @property string|null $role
 *
 * @property Tasks[] $tasks
 * @property UserCategories[] $userCategories
 * @property FavouriteUsers[] $favouriteUsers
 * @property Messages[] $messages
 * @property Profiles[] $profiles
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 * @property Cities $city
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'required'],
            [['city_id'], 'integer'],
            [['date_add'], 'safe'],
            [['email', 'name', 'password'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 45],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'city_id' => 'City ID',
            'password' => 'Password',
            'date_add' => 'Date Add',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[FavouriteUsers]].
     *
     * @return \yii\db\ActiveQuery|FavouriteUsersQuery
     */
    public function getFavouriteUsers()
    {
        return $this->hasMany(FavouriteUsers::className(), ['favorite_user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery|ProfilesQuery
     */
    public function getProfiles()
    {
        return $this->hasOne(Profiles::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery|UserCategoriesQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
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
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
