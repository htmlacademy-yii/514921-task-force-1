<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m200824_134308_add_views_count_column_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'profiles',
            'views_count',
            $this->integer()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profiles', 'views_count');
    }
}
