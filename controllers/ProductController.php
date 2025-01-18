<?php

namespace app\controllers;

use app\models\Category;
use app\models\ImageRel;
use app\models\Product;
use app\models\request\SearchProduct;
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
        $actions['index']['dataFilter'] = [
            // 'class' => (new SearchProduct)->search(\Yii::$app->request->queryParams),
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => SearchProduct::class,
            // 'attributeMap' => [
            //     'categoryName' => '{{' . Category::tableName() . '}}.[[name]]',
            // ],
            // 'searchModel' => (new \yii\base\DynamicModel(['id', 'name']))
            //     ->addRule(['id'], 'integer')
            //     ->addRule(['name'], 'string')
        ];

        return $actions;
    }

    public function actionCreate()
    {
        $product = new Product();

        if (!($product->load(Yii::$app->request->post(), '') && $product->validate())) {
            Yii::$app->response->statusCode = 422;
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
