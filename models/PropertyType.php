<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_types".
 *
 * @property int $id
 * @property string $name
 *
 * @property Property[] $properties
 */
class PropertyType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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

    /**
     * Gets query for [[Property]].
     */
    public function getProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Property::class, ['property_type_id' => 'id']);
    }
}
