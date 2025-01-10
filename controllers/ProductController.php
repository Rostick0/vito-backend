<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use app\models\request\SearchProduct;
use app\enum\PropertyType;
use app\utils\EnumFields;
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

        // dd(EnumFields::getValidateValues(PropertyType::class));
        // dd(PropertiyType::INPUT);
        return $actions;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();

        dd($model->load(\Yii::$app->request->post(), ''));
        // if ($this->request->isPost) {
        //     if ($model->load($this->request->post()) && $model->save()) {
        //         return $this->redirect(['view', 'id' => $model->id]);
        //     }
        // } else {
        //     $model->loadDefaultValues();
        // }

    }
}
