<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_categories}}`.
 */
class m200406_080220_create_user_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_categories}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-user_categories-category_id',
            '{{%user_categories}}',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-user_categories-user_id',
            '{{%user_categories}}',
            'user_id',
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
        $this->dropForeignKey('fk-user_categories-user_id', '{{%user_categories}}');
        $this->dropForeignKey('fk-user_categories-category_id', '{{%user_categories}}');
        $this->dropTable('{{%user_categories}}');
    }
}
