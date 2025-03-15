<?php

namespace app\controllers;

use app\models\Product;
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

        return $actions;
    }

    public function prepareDataProvider()
    {
        return (new ReviewSearch())
            ->search(Yii::$app->request->queryParams);
    }

    public function actionMy()
    {
        return(Yii::$app->user->id);
        $params = Yii::$app->request->queryParams;

        return Review::findOne([
            'reviewtable_id' => $params['reviewtable_id'],
            'reviewtable_type' => $params['reviewtable_type'],
            'user_id' => Yii::$app->user?->id,
        ]);
    }

    public function actionCreate()
    {
        $review = new Review();
        $post = Yii::$app->request->post();

        if (!($review->load(
            $post,
            ''
        ) && $review->validate())) {
            Yii::$app->response->setStatusCode(422);
            return $review->getErrors();
        }

        if (Review::findOne([
            'reviewtable_id' => $post['reviewtable_id'],
            'reviewtable_type' => $post['reviewtable_type'],
            'user_id' => Yii::$app->user?->id,
        ])) {
            Yii::$app->response->setStatusCode(400);
            return [
                'message' => 'You have review'
            ];
        }

        $review->save();

        // $review->extendsMutation(Yii::$app->request);

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

        // $review->extendsMutation(Yii::$app->request);

        return $review;
    }

    public function actionMarks($id)
    {
        return Review::find()->groupBy('mark')
            ->select(['count(mark) as count', 'mark'])
            ->where([
                'reviewtable_id' => $id,
                'reviewtable_type' => Yii::$app->request->getQueryParam('reviewtable_type'),
                // 'reviewtable_type' => Product::class,
            ])
            ->orderBy('mark DESC')
            ->asArray()
            ->all();
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
