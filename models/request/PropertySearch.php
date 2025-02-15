<?php

namespace app\models\request;

use app\models\Category;
use app\models\Property;
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
class PropertySearch extends Property
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['id', 'vendor_id', 'category_id'], 'integer'],
            [['is_specified', 'is_filter'], 'boolean'],
            // [['created_at'], 'safe'],
            [['name', 'unit'], 'string', 'max' => 255],
            // [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::class, 'targetAttribute' => ['vendor_id' => 'id']],
            // [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function search($params)
    {
        return FilterFull::search(Property::find(), $params);
    }
}
