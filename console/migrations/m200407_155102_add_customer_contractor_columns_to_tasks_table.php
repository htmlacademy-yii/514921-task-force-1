<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tasks}}`.
 */
class m200407_155102_add_customer_contractor_columns_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'tasks',
            'customer_id',
            $this->integer()
        );
        $this->addColumn(
            'tasks',
            'contractor_id',
            $this->integer()
        );
        $this->addForeignKey(
            'fk-tasks_customer_id-users_id',
            'tasks',
            'customer_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-tasks_contractor_id-users_id',
            'tasks',
            'contractor_id',
            'users',
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
        $this->dropForeignKey('fk-tasks_contractor_id-users_id','tasks');
        $this->dropForeignKey('fk-tasks_customer_id-users_id','tasks');
        $this->dropColumn('tasks','contractor_id');
        $this->dropColumn('tasks','customer_id');
    }
}
