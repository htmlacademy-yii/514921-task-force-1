<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles adding columns to table `{{%reviews}}`.
 */
class m200505_184723_add_task_status_column_to_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'reviews',
            'task_completion_status',
            Schema::TYPE_STRING
        );
        $this->addColumn(
            'reviews',
            'task_id',
            $this->integer()
        );
        $this->addForeignKey(
            'fk-reviews_task_id-tasks_id',
            'reviews',
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
        $this->dropForeignKey('fk-reviews_task_id-tasks_id', 'reviews');
        $this->dropColumn('reviews','task_id');
        $this->dropColumn('reviews','task_completion_status');
    }
}
