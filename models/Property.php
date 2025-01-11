<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "properties".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $unit
 * @property int $property_type_id
 *
 * @property ProductProperty[] $productProperties
 * @property PropertyCategory[] $propertyCategories
 * @property PropertyType $propertyType
 * @property PropertyValue[] $propertyValues
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'property_type_id'], 'required'],
            [['type'], 'string'],
            [['property_type_id'], 'integer'],
            [['name', 'unit'], 'string', 'max' => 255],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyType::class, 'targetAttribute' => ['property_type_id' => 'id']],
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
            'type' => 'Type',
            'unit' => 'Unit',
            'property_type_id' => 'Property Type ID',
        ];
    }

    /**
     * Gets query for [[ProductProperty]].
ƒ     */
    public function getProductProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ProductProperty::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[PropertyCategories]].
     */
    public function getPropertyCategories(): \yii\db\ActiveQuery
    {
        return $this->hasMany(PropertyCategory::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[PropertyType]].
     */
    public function getPropertyType(): \yii\db\ActiveQuery
    {
        return $this->hasOne(PropertyType::class, ['id' => 'property_type_id']);
    }

    /**
     * Gets query for [[PropertyValue]].
     */
    public function getPropertyValues(): \yii\db\ActiveQuery
    {
        return $this->hasMany(PropertyValue::class, ['property_id' => 'id']);
    }
}
