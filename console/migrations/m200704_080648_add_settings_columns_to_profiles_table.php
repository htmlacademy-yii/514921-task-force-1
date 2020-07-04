<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m200704_080648_add_settings_columns_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'profiles',
            'message_notifications',
            Schema::TYPE_BOOLEAN
        );
        $this->addColumn(
            'profiles',
            'task_notifications',
            Schema::TYPE_BOOLEAN
        );
        $this->addColumn(
            'profiles',
            'review_notifications',
            Schema::TYPE_BOOLEAN
        );
        $this->addColumn(
            'profiles',
            'hide_contact_info',
            Schema::TYPE_BOOLEAN
        );
        $this->addColumn(
            'profiles',
            'hide_profile',
            Schema::TYPE_BOOLEAN
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profiles', 'hide_profile');
        $this->dropColumn('profiles', 'hide_contact_info');
        $this->dropColumn('profiles', 'review_notifications');
        $this->dropColumn('profiles', 'task_notifications');
        $this->dropColumn('profiles', 'message_notifications');
    }
}
