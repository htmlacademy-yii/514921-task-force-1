<?php

namespace frontend\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property int|null $city_id
 * @property float|null $budget
 * @property string|null $date_expire
 * @property string|null $date_add
 * @property string|null $coordinates
 * @property string|null $address
 * @property string|null $status
 * @property int|null $customer_id
 * @property int|null $contractor_id
 *
 * @property Attachments[] $attachments
 * @property Events[] $events
 * @property Messages[] $messages
 * @property Replies[] $replies
 * @property Reviews[] $reviews
 * @property Categories $category
 * @property Users $contractor
 * @property Users $customer
 * @property Cities $city
 */
class Tasks extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $location = explode(" ", $this->coordinates);
            $this->coordinates = new Expression("ST_PointFromText('POINT({$location[0]} {$location[1]})')");

            return true;
        }
        return false;
    }

    public function afterFind()
    {
        if ($this->coordinates) {
            $geoData = unpack('x/x/x/x/corder/Ltype/dlongitude/dlatitude', $this->coordinates);
            $this->coordinates = $geoData;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'category_id'], 'required'],
            [['description', 'coordinates', 'status'], 'string'],
            [['category_id', 'city_id', 'customer_id', 'contractor_id'], 'integer'],
            [['budget'], 'number'],
            [['date_expire', 'date_add'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['contractor_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'budget' => 'Budget',
            'date_expire' => 'Date Expire',
            'date_add' => 'Date Add',
            'coordinates' => 'Coordinates',
            'address' => 'Address',
            'status' => 'Status',
            'customer_id' => 'Customer ID',
            'contractor_id' => 'Contractor ID',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::className(), ['task_id' => 'id']);
    }
    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery|EventsQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['task_id' => 'id']);
    }
    public function fields()
    {
        return [
            'title' => 'name',
            'published_at' => 'date_add',
            'new_messages' => function () {
                return $this->getMessages()->count();
            },
            'author_name' =>  function () {
                return $this->customer->name;
            },
            'id' => 'id',
        ];
    }
    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getContractor()
    {
        return $this->hasOne(Users::className(), ['id' => 'contractor_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'customer_id']);
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
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }
}
