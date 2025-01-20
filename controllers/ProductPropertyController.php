<?php

namespace app\controllers;

use app\models\ProductProperty;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

/**
 * ProductPropertyController implements the CRUD actions for Vendor model.
 */
class ProductPropertyController extends ActiveController
{
    public $modelClass = ProductProperty::class;


    // /**
    //  * Lists all Vendor models.
    //  *
    //  * @return string
    //  */
    // public function actionIndex()
    // {
    //     $searchModel = new VendorsQuery();
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }


}
