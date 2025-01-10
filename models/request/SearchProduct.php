<?php

namespace app\models\request;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $price
 * @property int|null $is_show
 * @property int|null $category_id
 * @property string|null $created_at
 *
 * @property Category $category
 */
// \yii\base\Model
class SearchProduct extends Product
{
    public $id;
    public $name;
    public $price;
    public $category_id;
    public $category;
    public $categoryName;
    // public $filters = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['id', 'is_show', 'category_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['categoryName'], 'string']
        ];
    }

    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params, '');

        // dd($dataProvider);

        return $dataProvider;
    }
}
