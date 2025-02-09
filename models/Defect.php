<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "defects".
 *
 * @property int $id
 * @property string $name
 * @property int $defect_type_id
 *
 * @property AdvertisementDefect[] $advertisementDefects
 * @property DefectCategory[] $defectCategories
 * @property DefectType $defectType
 */
class Defect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'defects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'defect_type_id'], 'required'],
            [['defect_type_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['defect_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DefectType::class, 'targetAttribute' => ['defect_type_id' => 'id']],
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
            'defect_type_id' => 'Defect Type ID',
        ];
    }

    public function extraFields()
    {
        return ['advertisementDefects', 'defectCategories', 'defectType'];
    }

    /**
     * Gets query for [[AdvertisementDefect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisementDefects()
    {
        return $this->hasMany(AdvertisementDefect::class, ['defect_id' => 'id']);
    }

    /**
     * Gets query for [[DefectCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefectCategories()
    {
        return $this->hasMany(DefectCategory::class, ['defect_id' => 'id']);
    }

    /**
     * Gets query for [[DefectType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefectType()
    {
        return $this->hasOne(DefectType::class, ['id' => 'defect_type_id']);
    }
}
