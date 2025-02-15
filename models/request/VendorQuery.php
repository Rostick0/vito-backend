<?php

namespace app\models\request;

use app\models\Vendor;
use app\utils\Filter\FilterFull;

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

    public function search($params)
    {
        return FilterFull::search(Vendor::find(), $params);
    }
}
