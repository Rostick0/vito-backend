<?php

namespace app\controllers;

use app\models\Product;
use app\models\request\SearchProduct;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => SearchProduct::class,
        ];

        return $actions;
    }
}
