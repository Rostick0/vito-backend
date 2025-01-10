<?php

namespace app\models;

use app\models\request\VendorsQuery;
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
            // [['name'], 'safe'],
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

    // /**
    //  * {@inheritdoc}
    //  * @return VendorsQuery the active query used by this AR class.
    //  */
    // public static function find()
    // {
    //     return new VendorsQuery(get_called_class());
    // }
}
