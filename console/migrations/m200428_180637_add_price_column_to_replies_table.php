<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%replies}}`.
 */
class m200428_180637_add_price_column_to_replies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'replies',
            'price',
            $this->decimal(10, 0)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('replies', 'price');
    }
}
