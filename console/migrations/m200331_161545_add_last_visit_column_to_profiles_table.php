<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%profiles}}`.
 */
class m200331_161545_add_last_visit_column_to_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('profiles', 'last_visit', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profiles', 'last_visit');
    }
}
