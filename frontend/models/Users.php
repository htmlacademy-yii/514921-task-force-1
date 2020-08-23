<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

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
 * @property int|null $vk_id
 *
 * @property Tasks[] $tasks
 * @property UserCategories[] $userCategories
 * @property Events[] $events
 * @property FavouriteUsers[] $favouriteUsers
 * @property Messages[] $messages
 * @property Profiles[] $profiles
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 * @property Cities $city
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['city_id', 'vk_id'], 'integer'],
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
            'vk_id' => 'Vk ID',
        ];
    }
    public function isFavourite($userId)
    {
        $favUsers = $this->favouriteUsers;
        $favourite = array_filter($favUsers, function ($user) use ($userId) {
            return $userId === $user['favorite_user_id'];
        });
        return $favourite;
    }

    public function getUserAge()
    {
        $userBirthday = $this->profiles->birthday;
        if ($userBirthday) {
            $userAge = explode(',', \Yii::$app->formatter->asDuration(time() - strtotime($userBirthday)))[0];
            return $userAge;
        } else {
            return "";
        }
    }

    public function getUserRating()
    {
        $userId = $this->id;
        $reviews = Reviews::findAll(['user_id' => $userId]);
        $tasksCount = count($reviews);
        if (!$tasksCount) {
            return null;
        }
        $ratingCount = array_reduce($reviews, function ($acc, $review) {
            if ($review['rating'] !== null) {
                $acc += $review['rating'];
            }
            return $acc;
        }, 0);
        $result = (int) $ratingCount / (int) $tasksCount;
        return round($result, 2);
    }

    public function getCompletedTasksCount()
    {
        return Reviews::find()
            ->where(['user_id' => $this->id])
            ->andWhere(['=', 'task_completion_status', 'yes'])
            ->count();
    }

    public function getCustomerTasks()
    {
        return $this->hasMany(Tasks::className(), ['customer_id' => 'id']);
    }

    public function getUnreadNotifications()
    {
        return $this->getEvents()->Where(['notification_read' => null])->all();
    }
    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery|EventsQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FavouriteUsers]].
     *
     * @return \yii\db\ActiveQuery|FavouriteUsersQuery
     */
    public function getFavouriteUsers()
    {
        return $this->hasMany(FavouriteUsers::className(), ['user_id' => 'id']);
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
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

}
