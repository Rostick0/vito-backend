<?php

namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "advertisements".
 *
 * @property int $id
 * @property string $title
 * @property int $price
 * @property int $product_id
 * @property int $user_id
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 * @property AdvertisementProperty[] $advertisementProperties
 * @property Product $product
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'is_show'], 'required'],
            [['product_id'], 'required', 'on' => 'create'],
            [['price', 'product_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 65536],
            [['is_show'], 'boolean'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
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
        return ['advertisementProperties', 'product'];
    }

    /**
     * Gets query for [[AdvertisementProperty]].
     */
    public function getAdvertisementProperties(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AdvertisementProperty::class, ['advertisement_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     */
    public function getProduct(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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
