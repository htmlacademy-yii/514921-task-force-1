<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m200611_180349_add_telegram_avatar_columns_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'profiles',
            'telegram',
            Schema::TYPE_STRING
        );
        $this->addColumn(
            'profiles',
            'avatar',
            Schema::TYPE_STRING
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profiles', 'avatar');
        $this->dropColumn('profiles', 'telegram');
    }
}
