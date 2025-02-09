<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "defect_types".
 *
 * @property int $id
 * @property string $name
 *
 * @property Defect[] $defects
 */
class DefectType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'defect_types';
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

    public function extraFields()
    {
        return ['defects'];
    }

    /**
     * Gets query for [[Defects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefects()
    {
        return $this->hasMany(Defect::class, ['defect_type_id' => 'id']);
    }
}
