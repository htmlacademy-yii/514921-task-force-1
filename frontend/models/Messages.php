<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $message
 * @property int|null $task_id
 * @property string|null $published_at
 *
 * @property Tasks $task
 * @property Users $user
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['user_id', 'task_id'], 'integer'],
            [['message'], 'string'],
            [['published_at'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'message' => 'Message',
            'task_id' => 'Task ID',
            'published_at' => 'Published At',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['id'], $fields['user_id'], $fields['task_id']);
        return array_merge($fields, [
            'message' => 'message',
            'published_at' => 'published_at',
            'is_mine' => function () {
                return (int)Yii::$app->getUser()->getId() === $this->user_id;
            },
        ]);
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
     * @return MessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessagesQuery(get_called_class());
    }
}
