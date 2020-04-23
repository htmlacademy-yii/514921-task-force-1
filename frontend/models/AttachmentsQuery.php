<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Attachments]].
 *
 * @see Attachments
 */
class AttachmentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Attachments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Attachments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
