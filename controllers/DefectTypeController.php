<?php

namespace app\controllers;

use app\models\DefectType;
use app\models\request\DefectTypeSearch;
use yii\rest\ActiveController;
use Yii;

class DefectTypeController extends ActiveController
{
    public $modelClass = DefectType::class;

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
        return (new DefectTypeSearch())
            ->search(Yii::$app->request->queryParams);
    }
}
