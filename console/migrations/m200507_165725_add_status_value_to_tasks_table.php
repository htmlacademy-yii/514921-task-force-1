<?php

use yii\db\Migration;

/**
 * Class m200507_165725_add_status_value_to_tasks_table
 */
class m200507_165725_add_status_value_to_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
                UPDATE `mydb`.`tasks` SET `status` = 'new';
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200507_165725_add_status_value_to_tasks_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200507_165725_add_status_value_to_tasks_table cannot be reverted.\n";

        return false;
    }
    */
}
