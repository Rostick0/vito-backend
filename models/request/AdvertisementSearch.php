<?php

namespace app\models\request;

use app\models\Advertisement;
use app\models\Category;
use app\models\Office;
use app\models\Product;
use app\models\User;
use app\models\Vendor;
use app\utils\Filter\FilterFull;
use app\utils\Filter\FilterSearch;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_show
 * @property int|null $category_id
 * @property string|null $created_at
 *
 * @property Category $category
 */
// \yii\base\Model
class AdvertisementSearch extends Advertisement
{
    // public $id;
    // public $name;
    // public $category_id;
    // public $category;
    // public $categoryName;
    // public $productProperties;
    // public $productPropertiesName;
    // public $filters = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['id', 'product_id', 'office_id', 'user_id', 'price'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['office_id'], 'exist', 'skipOnError' => true, 'targetClass' => Office::class, 'targetAttribute' => ['office_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            // 'created_at' => $this->dateTime(),
            // 'updated_at' => $this->dateTime(),
        ];
    }

    public function search($params)
    {
        return FilterFull::search(Advertisement::find(), $params);
    }
}
