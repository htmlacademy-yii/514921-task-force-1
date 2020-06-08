<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%messages}}`.
 */
class m200601_153821_add_is_mine_and_published_at_columns_to_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'messages',
            'is_mine',
            $this->boolean()
        );
        $this->addColumn(
            'messages',
            'published_at',
            $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('messages', 'published_at');
        $this->dropColumn('messages', 'is_mine');
    }
}
