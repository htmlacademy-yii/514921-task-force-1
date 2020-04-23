<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%attachments}}`.
 */
class m200423_135557_create_attachments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachments}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->addForeignKey(
            'fk-attachments_task_id-tasks_id',
            '{{%attachments}}',
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
        $this->dropForeignKey('fk-attachments_task_id-tasks_id', '{{%attachments}}');
        $this->dropTable('{{%attachments}}');
    }
}
