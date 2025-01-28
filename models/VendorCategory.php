<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor_categories".
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Vendor $vendor
 */
class VendorCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendor_id', 'category_id'], 'required'],
            [['vendor_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['vendor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor ID',
            'category_id' => 'Category ID',
        ];
    }

    public function extraFields()
    {
        return ['image', 'category', 'vendor'];
    }

    public function getImage(): \yii\db\ActiveQuery
    {
        return $this->hasOne(ImageRel::class, ['reltable_id' => 'id'])->where(['reltable_type' => $this::class]);
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
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::class, ['id' => 'vendor_id']);
    }
}
