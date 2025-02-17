<?php

namespace app\models;

use yii\db\ActiveRecord;
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
 * is_show
 * @property string|null $created_at
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    public $mainImage;

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
            [['is_show'], 'boolean'],
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

    public function behaviors()
    {
        return [
            'mainImage' => [
                'class' => \yii\behaviors\AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'mainImage',
                ],
                'value' => function ($event) {
                    return $this->getImages()->one()?->getRelation('image')?->one();
                },
            ],
        ];
    }

    public function extraFields()
    {
        return ['images', 'mainImage', 'category', 'vendor', 'productProperties', 'reviews', 'reviewsCount'];
    }

    /**
     * Gets query for [[Image]].
     */
    public function getImages(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ImageRel::class, ['reltable_id' => 'id'])->where(['reltable_type' => $this::class]);
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

    /**
     * Gets query for [[ProductProperty]].
     */
    public function getProductProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ProductProperty::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     */
    public function getReviews(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Review::class, ['reviewtable_id' => 'id'])->where(['reviewtable_type' => $this::class]);
    }

    /**
     * Gets query for [[ReviewsCount]].
     */
    public function getReviewsCount()
    {
        return $this->getReviews()->count();
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
        //     Yii::$app->response->setStatusCode(422);
        //     return $errors;
        // }
    }
}
