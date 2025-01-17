<?php

namespace app\controllers;

use app\models\Category;
use app\models\ImageRel;
use app\models\Advertisement;
use app\models\AdvertisementProperty;
use Yii;

class AdvertisementController extends \yii\rest\ActiveController
{
    public $modelClass = Advertisement::class;

    public function extendsMutation($advertisement)
    {
        if ($images = Yii::$app->request->getBodyParam('images')) {
            ImageRel::deleteAll([
                'reltable_id' => $advertisement->id,
                'reltable_type' => Advertisement::class
            ]);

            foreach (explode(',', $images) as $image_id) {
                $image = new ImageRel();

                if ($image->load([
                    'image_id' => $image_id,
                    'reltable_id' => $advertisement->id,
                    'reltable_type' => Advertisement::class
                ], '') && $image->validate()) {
                    $image->save();
                }
            }
        }

        if ($properties_products = Yii::$app->request->getBodyParam('properties_products')) {
            AdvertisementProperty::deleteAll([
                'advertisement_id' => $advertisement->id,
            ]);

            foreach ($properties_products as $product_property_id) {
                $advertisement_property = new AdvertisementProperty();

                if ($advertisement_property->load([
                    'product_property_id' => $product_property_id,
                    'advertisement_id' => $advertisement->id,
                ], '') && $advertisement_property->validate()) {
                    $advertisement_property->save();
                }
            }
        }
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
        ];

        return $actions;
    }

    public function actionCreate()
    {
        $advertisement = new Advertisement();

        if (!($advertisement->load(Yii::$app->request->post(), '') && $advertisement->validate())) {
            Yii::$app->response->statusCode = 422;
            return $advertisement->getErrors();
        }

        $advertisement->save();

        $this->extendsMutation($advertisement);

        return $advertisement;
    }

    public function actionUpdate($id,$a) {
// dd($id);
dd($a);
    }

    public function checkAccess($action, $model = null, $params = []) {}
}
