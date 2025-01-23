<?php

namespace app\controllers;

use app\models\request\VendorQuery;
use app\models\Vendor;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends ActiveController
{
    public $modelClass = Vendor::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => VendorQuery::class,
        ];

        return $actions;
    }

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

    // /**
    //  * Creates a new Vendor model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return string|\yii\web\Response
    //  */
    // public function actionCreate()
    // {
    //     $model = new Vendor();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing Vendor model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param int $id ID
    //  * @return string|\yii\web\Response
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }
}
