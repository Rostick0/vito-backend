<?php

namespace app\models\request;

use app\models\DefectType;
use app\utils\Filter\FilterFull;
use Yii;
use yii\data\ActiveDataProvider;

class DefectTypeSearch extends DefectType
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
        return FilterFull::search(DefectType::find(), $params);
    }
}
