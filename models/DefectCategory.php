<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "defect_categories".
 *
 * @property int $id
 * @property int $defect_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Defect $defect
 */
class DefectCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'defect_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['defect_id', 'category_id'], 'required'],
            [['defect_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['defect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Defect::class, 'targetAttribute' => ['defect_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'defect_id' => 'Defect ID',
            'category_id' => 'Category ID',
        ];
    }

    public function extraFields()
    {
        return ['category', 'defect'];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Defect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefect()
    {
        return $this->hasOne(Defect::class, ['id' => 'defect_id']);
    }
}
