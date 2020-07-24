<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%profiles}}`.
 */
class m200611_175408_drop_address_column_from_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('profiles', 'address');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('profiles', 'address');
    }
}
