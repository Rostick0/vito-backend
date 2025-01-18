<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int|null $is_show
 * @property int $category_id
 * @property int $vendor_id
 * @property string|null $created_at
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'vendor_id'], 'required'],
            // [['price'], 'double'],
            [['category_id', 'vendor_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'category_id' => 'Category ID',
            'vendor_id' => 'Vendor ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Category]].
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Vendor]].
     */
    public function getVendor(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Vendor::class, ['id' => 'vendor_id']);
    }

    public function extendsMutation(yii\web\Request $request): void
    {
        if ($images = $request->getBodyParam('images')) {
            foreach (explode(',', $images) as $image_id) {
                $image = new ImageRel();

                if ($image->load([
                    'image_id' => $image_id,
                    'reltable_id' => $this->id,
                    'reltable_type' => Product::class
                ], '') && $image->validate()) {
                    $image->save();
                }
            }
        }

        // if ($properties = Yii::$app->request->getBodyParam('properties'));

        // if ($errors) {
        //     Yii::$app->response->statusCode = 422;
        //     return $errors;
        // }
    }
}
