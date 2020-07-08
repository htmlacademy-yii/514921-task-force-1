<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%events}}`.
 */
class m200707_155201_create_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%events}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'email_sent' =>$this->timestamp(),
            'notification_read' =>$this->timestamp(),
        ]);
        $this->addForeignKey(
            'fk-events_user_id-users_id',
            '{{%events}}',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-events_task_id-tasks_id',
            '{{%events}}',
            'task_id',
            'tasks',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-events_task_id-tasks_id', '{{%events}}');
        $this->dropForeignKey('fk-events_user_id-users_id', '{{%events}}');
        $this->dropTable('{{%events}}');
    }
}
