<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%messages}}`.
 */
class m200529_140406_add_task_id_column_to_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'messages',
            'task_id',
            $this->integer()
        );
        $this->addForeignKey(
            'fk-messages_task_id-tasks_id',
            'messages',
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
        $this->dropForeignKey('fk-messages_task_id-tasks_id', 'messages');
        $this->dropColumn('messages', 'task_id');
    }
}
