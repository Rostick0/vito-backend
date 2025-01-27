<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "offices".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['name', 'address'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}
