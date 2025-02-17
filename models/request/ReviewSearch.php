<?php

namespace app\models\request;

use app\models\Review;
use app\utils\Filter\FilterSearch;
use Yii;
use yii\data\ActiveDataProvider;

class ReviewSearch extends Review
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    public function search($params)
    {
        $query = Review::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (isset($params['filter'])) {
            (new FilterSearch)->run($query, $params);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
