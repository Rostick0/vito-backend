<?php

namespace app\models\request;

use app\models\Category;
use app\models\Product;
use app\utils\Filter\FilterFull;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $category_id
 *
 * @property Product[] $products
 */
class CategorySearch extends Category
{
    public $id;
    public $name;
    public $category_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['id', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function search($params)
    {
        return FilterFull::search(Category::find(), $params);
    }
}
