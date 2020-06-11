<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%messages}}`.
 */
class m200610_150959_drop_is_mine_column_from_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('messages', 'is_mine');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
