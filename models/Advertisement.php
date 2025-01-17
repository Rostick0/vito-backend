<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertisements".
 *
 * @property int $id
 * @property string $title
 * @property int|null $price
 * @property int|null $product_id
 *
 * @property AdvertisementProperty[] $advertisementProperties
 * @property Product $product
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['price', 'product_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[AdvertisementProperty]].
     */
    public function getAdvertisementProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AdvertisementProperty::class, ['advertisement_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
