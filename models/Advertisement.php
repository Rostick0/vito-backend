<?php

namespace app\models;

use DateTime;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "advertisements".
 *
 * @property int $id
 * @property string $title
 * @property int $price
 * @property $is_show
 * @property int $product_id
 * @property int $user_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @property AdvertisementProperty[] $advertisementProperties
 * @property Product $product
 */
class Advertisement extends ActiveRecord
{
    public $mainImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisements';
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['product_id'], 'required', 'on' => 'create'],
            [['price', 'product_id', 'office_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 65536],
            [['is_show'], 'boolean'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => Office::class, 'targetAttribute' => ['office_id' => 'id']],
            [['mainImage'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'product_id' => 'Product ID',
            'user_id' => 'User ID'
        ];
    }

    public function extraFields()
    {
        return ['advertisementProperties', 'images', 'mainImage', 'product', 'user'];
    }

    /**
     * Gets query for [[AdvertisementProperty]].
     */
    public function getAdvertisementProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AdvertisementProperty::class, ['advertisement_id' => 'id']);
    }

    /**
     * Gets query for [[Image]].
     */
    // public function getMainImage(): \yii\db\ActiveQuery
    // {
    //     return $this->getImages()->first;
    // }

    /**
     * Gets query for [[Image]].
     */
    public function getImages(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ImageRel::class, ['reltable_id' => 'id'])->where(['reltable_type' => $this::class]);
    }

    /**
     * Gets query for [[Product]].
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function extendsMutation(yii\web\Request $request): void
    {
        if ($images = $request->getBodyParam('images')) {
            ImageRel::deleteAll([
                'reltable_id' => $this->id,
                'reltable_type' => Advertisement::class
            ]);

            foreach (explode(',', $images) as $image_id) {
                $image = new ImageRel();

                if ($image->load([
                    'image_id' => $image_id,
                    'reltable_id' => $this->id,
                    'reltable_type' => Advertisement::class
                ], '') && $image->validate()) {
                    $image->save();
                }
            }
        }

        if ($properties_products = $request->getBodyParam('properties_products')) {
            AdvertisementProperty::deleteAll([
                'advertisement_id' => $this->id,
            ]);

            foreach ($properties_products as $product_property_id) {
                // dd($product_property_id);
                $advertisement_property = new AdvertisementProperty();

                if ($advertisement_property->load([
                    'product_property_id' => $product_property_id,
                    'advertisement_id' => $this->id,
                ], '') && $advertisement_property->validate()) {
                    $advertisement_property->save();
                }
            }
        }
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = Yii::$app->user->id ?? 1;
            } else {
                $this->updated_at = (new \DateTimeImmutable())->format("Y-m-d H:i:s");
            }

            return true;
        }

        return false;
    }
}
