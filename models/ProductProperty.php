<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_properties".
 *
 * @property int $id
 * @property int|null $value
 * @property int $property_id
 * @property int $property_value_id
 * @property int $product_id
 *
 * @property Product $product
 * @property Property $property
 * @property PropertyValue $propertyValue
 */
class ProductProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'property_id', 'property_value_id', 'product_id'], 'integer'],
            [['property_id', 'product_id'], 'required'],
            [['is_specified'], 'boolean'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
            [['property_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyValue::class, 'targetAttribute' => ['property_value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'property_id' => 'Property ID',
            'property_value_id' => 'Property Value ID',
            'product_id' => 'Product ID',
        ];
    }

    public function extraFields()
    {
        return ['product', 'property', 'propertyValue'];
    }

    /**
     * Gets query for [[Product]].
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Property]].
     */
    public function getProperty(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    /**
     * Gets query for [[PropertyValue]].
     */
    public function getPropertyValue(): \yii\db\ActiveQuery
    {
        return $this->hasOne(PropertyValue::class, ['id' => 'property_value_id']);
    }
}
