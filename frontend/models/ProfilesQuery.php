<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Profiles]].
 *
 * @see Profiles
 */
class ProfilesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Profiles[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Profiles|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
