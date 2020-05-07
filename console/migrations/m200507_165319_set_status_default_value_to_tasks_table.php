<?php

use yii\db\Migration;

/**
 * Class m200507_165319_set_status_default_value_to_tasks_table
 */
class m200507_165319_set_status_default_value_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks','status', $this->string()->defaultValue('new'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks','status', $this->string());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200507_165319_set_status_default_value_to_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
