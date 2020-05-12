<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%replies}}`.
 */
class m200501_121219_add_failed_tasks_count_column_to_replies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'replies',
            'failed_tasks_count',
            $this->integer()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('replies','failed_tasks_count');
    }
}
