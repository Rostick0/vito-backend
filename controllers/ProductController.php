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

        // dd(EnumFields::getValidateValues(PropertyTypeEnum::class));
        // dd(PropertiyType::INPUT);
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

        if ($images = Yii::$app->request->getBodyParam('images')) {
            foreach (explode(',', $images) as $image_id) {
                $image = new ImageRel();

                if ($image->load([
                    'image_id' => $image_id,
                    'reltable_id' => $product->id,
                    'reltable_type' => Product::class
                ], '') && $image->validate()) {
                    $image->save();
                }
            }
        }

        // if ($properties = Yii::$app->request->getBodyParam('params'));

        // if ($errors) {
        //     Yii::$app->response->statusCode = 422;
        //     return $errors;
        // }

        return $product;
    }
}
