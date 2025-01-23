<?php

namespace app\models\request;

use app\models\Category;
use app\models\Product;
use app\models\Vendor;
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
class ProductQuery extends Product
{
    // public $id;
    // public $name;
    // public $category_id;
    // public $category;
    // public $categoryName;
    public $productProperties;
    public $productPropertiesName;
    // public $filters = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vendor_id', 'category_id'], 'integer'],
            [['is_show'], 'boolean'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['vendor_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function search($params)
    {
        // $query = Product::find()->with(['productProperties']);
        // dd(Product::getTableSchema());
        $query = Product::find()
            ->joinWith('productProperties')
            // ->with('productProperties')
            // ->where(['product_properties.id' => '1']);
            // ->where(['product_properties.id' => 1])
        ;
        $query = $query->andWhere([Product::tableName() . '.id' => '1']);

        $query = $query->andWhere(['product_properties.id' => '4607']);
        // $query->andWhere([Product::tableName() . '.id' => '2']);

        if (isset($params['filter'])) {
            foreach ($params['filter'] as $i => $param) {
                dd($i, $param);
            }
        }
        dd($query->all());
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // dd($params);

        $this->load($params);

        $this->validate();
        // dd($dataProvider);

        return $dataProvider;
    }
}
