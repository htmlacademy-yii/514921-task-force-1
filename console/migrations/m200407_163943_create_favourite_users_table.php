<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favourites_users}}`.
 */
class m200407_163943_create_favourite_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favourite_users}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'favorite_user_id' =>$this->integer()->notNull()
        ]);
        $this->addForeignKey(
            'fk-user_id-users_id',
            '{{%favourite_users}}',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-favorite_user-users_id',
            '{{%favourite_users}}',
            'favorite_user_id',
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
        $this->dropForeignKey('fk-favorite_user-users_id','{{%favourite_users}}');
        $this->dropForeignKey('fk-user_id-users_id','{{%favourite_users}}');
        $this->dropTable('{{%favourite_users}}');
    }
}
