<?php

namespace app\controllers;

use app\models\Property;
use app\models\request\PropertySearch;
use yii\rest\ActiveController;
use Yii;

class PropertyController extends ActiveController
{
    public $modelClass = Property::class;

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
        return (new PropertySearch())
            ->search(Yii::$app->request->queryParams);
    }
}
