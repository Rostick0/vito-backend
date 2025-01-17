<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertisement_properties".
 *
 * @property int $id
 * @property int|null $value
 * @property int $property_id
 * @property int $property_value_id
 * @property int $advertisement_id
 *
 * @property Advertisement $advertisement
 * @property Property $property
 * @property PropertyValue $propertyValue
 */
class AdvertisementProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement_properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_property_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductProperty::class, 'targetAttribute' => ['product_property_id' => 'id']],
            [['advertisement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::class, 'targetAttribute' => ['advertisement_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_property_id' => 'Product Property ID',
            'advertisement_id' => 'Advertisement ID',
        ];
    }

    /**
     * Gets query for [[Advertisement]].
     */
    public function getAdvertisement(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Advertisement::class, ['id' => 'advertisement_id']);
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
