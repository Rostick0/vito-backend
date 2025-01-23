<?php

namespace app\models\request;

use app\models\Vendor;

/**
 * This is the ActiveQuery class for [[Vendor]].
 *
 * @see Vendor
 */
// \yii\db\ActiveQuery
class VendorQuery extends Vendor
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }
}
