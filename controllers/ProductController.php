<?php

namespace app\controllers;

use app\models\ImageRel;
use app\models\Product;
use app\models\request\ProductSearch;
use app\enum\PropertyTypeEnum;
use app\utils\EnumFields;
use Yii;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = Product::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return (new ProductSearch())
            ->search(Yii::$app->request->queryParams);
    }

    public function actionCreate()
    {
        $product = new Product();

        if (!($product->load(Yii::$app->request->post(), '') && $product->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $product->getErrors();
        }

        $product->save();

        return $product;
    }

    public function actionUpdate($id)
    {
        $product = Product::findOne($id);

        if ($product->load(Yii::$app->request->getBodyParams(), '') && $product->validate()) {
            $product->save();
        }

        return $product;
    }
}
