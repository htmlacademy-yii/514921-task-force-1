<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property resource|null $attachments
 * @property int|null $city_id
 * @property float|null $budget
 * @property string|null $date_expire
 * @property string|null $date_add
 * @property string|null $coordinates
 * @property string|null $address
 *
 * @property Replies[] $replies
 * @property Categories $category
 * @property Cities $city
 */
class Tasks extends \yii\db\ActiveRecord
{
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
            [['description', 'attachments', 'coordinates'], 'string'],
            [['category_id', 'city_id'], 'integer'],
            [['budget'], 'number'],
            [['date_expire', 'date_add'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'attachments' => 'Attachments',
            'city_id' => 'City ID',
            'budget' => 'Budget',
            'date_expire' => 'Date Expire',
            'date_add' => 'Date Add',
            'coordinates' => 'Coordinates',
            'address' => 'Address',
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
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
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
