<?php

namespace app\controllers;

use app\models\Category;
use app\models\request\CategorySearch;
use yii\rest\ActiveController;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends ActiveController
{
    public $modelClass = Category::class;

    // public $serializer = [
    //     'class' => 'yii\rest\Serializer',
    //     'collectionEnvelope' => 'data',
    // ];

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => CategorySearch::class,
        ];

        return $actions;
    }

    // public function actionIndex()
    // {
    //     $category = new Category();
    //     return new ActiveDataProvider([
    //         'query' => $category->search(Yii::$app->request->queryParams),
    //     ]);
    // }

}
