<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FavouriteUsers]].
 *
 * @see FavouriteUsers
 */
class FavouriteUsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FavouriteUsers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FavouriteUsers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
