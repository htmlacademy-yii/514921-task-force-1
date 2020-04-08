<?php

use yii\db\Migration;

/**
 * Class m200408_082450_add_test_data_to_tables
 */
class m200408_082450_add_test_data_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '6');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '8');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '12');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '1');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '9');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '18');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '19');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '15');
                UPDATE `mydb`.`users` SET `role` = 'contractor' WHERE (`id` = '3');
        ");
        $this->execute(
            "INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('4', '6');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('5', '6');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('3', '8');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('3', '12');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('2', '1');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('2', '9');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('1', '18');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('1', '19');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('6', '6');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('7', '3');
                INSERT INTO `mydb`.`user_categories` (`category_id`, `user_id`) VALUES ('8', '15');"
        );
        $this->execute("
                UPDATE `mydb`.`tasks` SET `contractor_id` = '2' WHERE (`id` = '1');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '2' WHERE (`id` = '2');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '4' WHERE (`id` = '3');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '4' WHERE (`id` = '4');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '7' WHERE (`id` = '5');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '15' WHERE (`id` = '6');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '10' WHERE (`id` = '7');
                UPDATE `mydb`.`tasks` SET `contractor_id` = '10' WHERE (`id` = '8');
        ");
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200408_082450_add_test_data_to_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200408_082450_add_test_data_to_tables cannot be reverted.\n";

        return false;
    }
    */
}
