<?php

namespace app\controllers;

use app\models\Review;
use app\models\request\ReviewSearch;
use Yii;

class ReviewController extends \yii\rest\ActiveController
{
    public $modelClass = Review::class;

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
        return (new ReviewSearch())
            ->search(Yii::$app->request->queryParams);
    }

    public function actionCreate()
    {
        $review = new Review();

        if (!($review->load(
            Yii::$app->request->post(),
            ''
        ) && $review->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $review->getErrors();
        }

        $review->save();

        $review->extendsMutation(Yii::$app->request);

        return $review;
    }

    public function actionUpdate($id)
    {
        $review = Review::findOne($id);

        $this->checkAccess('update', $review);

        if (!($review->load(
            Yii::$app->request->getBodyParams(),
            ''
        ) && $review->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $review->getErrors();
        }

        $review->save();

        $review->extendsMutation(Yii::$app->request);

        return $review;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (
            array_search($action, ['update', 'delete']) !== false &&
            !(Yii::$app->user->identity?->role === 'admin' || Yii::$app->user?->id === $model?->user_id)
        ) {
            throw new \yii\web\ForbiddenHttpException('No access');
        }
    }
}
