<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%user_pictures}}`.
 */
class m200611_184354_create_user_pictures_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_pictures}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer()->notNull(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);

        $this->addForeignKey(
            'fk-user_pictures_profile_id-profiles_id',
            '{{%user_pictures}}',
            'profile_id',
            'profiles',
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
        $this->dropForeignKey('fk-user_pictures_profile_id-profiles_id', '{{%user_pictures}}');
        $this->dropTable('{{%user_pictures}}');
    }
}
