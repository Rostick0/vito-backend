<?php

namespace app\models;

use app\models\request\VendorQuery;
use Yii;

/**
 * This is the model class for table "vendors".
 *
 * @property int $id
 * @property string|null $name
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass' => \app\models\Vendor::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function extraFields()
    {
        return ['image', 'products'];
    }

    /**
     * Gets query for [[Image]].
     */
    public function getImage(): \yii\db\ActiveQuery
    {
        return $this->hasOne(ImageRel::class, ['reltable_id' => 'id'])->where(['reltable_type' => $this::class]);
    }

    /**
     * Gets query for [[Product]].
     */
    public function getProducts(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Product::class, ['vendor_id' => 'id']);
    }
}
