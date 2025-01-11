<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_values".
 *
 * @property int $id
 * @property string $value
 * @property int $property_id
 *
 * @property ProductProperty[] $productProperties
 * @property Property $property
 */
class PropertyValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'property_id'], 'required'],
            [['property_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[ProductProperty]].
     */
    public function getProductProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ProductProperty::class, ['property_value_id' => 'id']);
    }

    /**
     * Gets query for [[Property]].
     */
    public function getProperty(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }
}
