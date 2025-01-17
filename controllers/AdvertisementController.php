<?php

namespace app\controllers;

use app\models\Category;
use app\models\ImageRel;
use app\models\Advertisement;
use Yii;

class AdvertisementController extends \yii\rest\ActiveController
{
    public $modelClass = Advertisement::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
        ];

        return $actions;
    }

    public function actionCreate()
    {
        // $advertisement = new Advertisement();

        // if (!($advertisement->load(Yii::$app->request->post(), '') && $advertisement->validate())) {
        //     Yii::$app->response->statusCode = 422;
        //     return $advertisement->getErrors();
        // }

        // $advertisement->save();

        // if ($images = Yii::$app->request->getBodyParam('images')) {
        //     foreach (explode(',', $images) as $image_id) {
        //         $image = new ImageRel();

        //         if ($image->load([
        //             'image_id' => $image_id,
        //             'reltable_id' => $advertisement->id,
        //             'reltable_type' => Advertisement::class
        //         ], '') && $image->validate()) {
        //             $image->save();
        //         }
        //     }
        // }

        if ($properties_products = Yii::$app->request->getBodyParam('properties_products')) {
            dd($properties_products);
        }

        return '';
        // return $advertisement;
    }
}
