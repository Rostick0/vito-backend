<?php

namespace app\models\request;

use app\models\Category;
use Yii;

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
class SearchProduct extends \yii\base\Model
{
    public $id;
    public $name;
    public $price;
    public $category_id;
    public $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['is_show', 'category_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
}
