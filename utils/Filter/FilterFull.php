<?php

namespace app\utils\Filter;

use app\utils\Filter\FilterSearch;
use Yii;
use yii\data\ActiveDataProvider;

class FilterFull
{
    public static function search($query, $params)
    {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => min($params['limit'] ?? Yii::$app->params['pagination']['default'], Yii::$app->params['pagination']['max']),
            ],
        ]);


        if (isset($params['filter'])) {
            (new FilterSearch)->run($query, $params);
        }

        // if (!($this->validate() && $this->load($params))) {
        //     return $dataProvider;
        // }

        return $dataProvider;
    }
}
