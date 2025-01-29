<?php

namespace app\controllers;

use app\models\Advertisement;
use app\models\request\AdvertisementSearch;
use Yii;

class AdvertisementController extends \yii\rest\ActiveController
{
    public $modelClass = Advertisement::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // $behaviors['authenticator'] = [
        //     'class' => \bizley\jwt\JwtHttpBearerAuth::class,
        //     'except' => [
        //         'index',
        //         'view',
        //     ],
        // ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        
        // $actions['index']['dataFilter'] = [
        //     'class' => \yii\data\ActiveDataFilter::class,
        //     'searchModel' => $this->modelClass,
        // ];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return (new AdvertisementSearch())
            ->search(Yii::$app->request->queryParams);
    }

    public function actionCreate()
    {
        $advertisement = new Advertisement();

        if (!($advertisement->load(
            Yii::$app->request->post(),
            ''
        ) && $advertisement->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $advertisement->getErrors();
        }

        $advertisement->save();

        $advertisement->extendsMutation(Yii::$app->request);

        return $advertisement;
    }

    public function actionUpdate($id)
    {
        $advertisement = Advertisement::findOne($id);

        $this->checkAccess('update', $advertisement);

        if (!($advertisement->load(
            Yii::$app->request->getBodyParams(),
            ''
        ) && $advertisement->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $advertisement->getErrors();
        }

        $advertisement->save();

        $advertisement->extendsMutation(Yii::$app->request);

        return $advertisement;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (
            array_search($action, ['update', 'delete']) !== false &&
            !(Yii::$app->user->identity->role === 'admin' || Yii::$app->user?->id === $model?->user_id)
        ) {
            throw new \yii\web\ForbiddenHttpException('No access');
        }
    }
}
