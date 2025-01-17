<?php

namespace app\models\request;

use app\models\Vendor;

/**
 * This is the ActiveQuery class for [[Vendor]].
 *
 * @see Vendor
 */
class VendorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Vendor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Vendor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
