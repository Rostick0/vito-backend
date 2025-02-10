<?php

namespace app\controllers;

use app\models\Defect;
use app\models\request\DefectSearch;
use yii\rest\ActiveController;
use Yii;

class DefectController extends ActiveController
{
    public $modelClass = Defect::class;

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
        return (new DefectSearch())
            ->search(Yii::$app->request->queryParams);
    }
}
