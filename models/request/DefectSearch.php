<?php

namespace app\models\request;

use app\models\Defect;
use app\utils\Filter\FilterFull;
use app\utils\Filter\FilterSearch;
use Yii;
use yii\data\ActiveDataProvider;

class DefectSearch extends Defect
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
            // [['name'], 'trim'],
            // [['id', 'category_id'], 'integer'],
            // [['name'], 'string', 'max' => 255],
        ];
    }

    public function search($params)
    {
        return FilterFull::search(Defect::find(), $params);
    }
}
