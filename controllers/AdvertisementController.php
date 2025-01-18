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

        if (!($advertisement->load(
            [...Yii::$app->request->post(), 'user_id' => Yii::$app->user->id],
            ''
        ) && $advertisement->validate())) {
            Yii::$app->response->statusCode = 422;
            return $advertisement->getErrors();
        }

        $advertisement->save();

        $advertisement->extendsMutation(Yii::$app->request);

        return $advertisement;
    }

    public function actionUpdate($id)
    {
        $advertisement = Advertisement::findOne($id);

        if ($advertisement->user_id !== Yii::$app->user->id) {
            return;
        }

        if (!($advertisement->load(
            Yii::$app->request->getBodyParams(),
            ''
        ) && $advertisement->validate())) {
            Yii::$app->response->statusCode = 422;
            return $advertisement->getErrors();
        }

        $advertisement->save();

        $advertisement->extendsMutation(Yii::$app->request);

        return $advertisement;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // dd($action);
    }
}
