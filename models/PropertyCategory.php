<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property_categories".
 *
 * @property int $id
 * @property int $property_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Property $property
 */
class PropertyCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'category_id'], 'required'],
            [['property_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'property_id' => 'Property ID',
            'category_id' => 'Category ID',
        ];
    }

    public function extraFields()
    {
        return ['category', 'property'];
    }

    /**
     * Gets query for [[Category]].
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Property]].
     */
    public function getProperty(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }
}
