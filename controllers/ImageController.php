<?php

namespace app\controllers;

use app\models\request\ImageForm;
use Yii;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImageController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionUpload()
    {
        $model = new ImageForm();

        if (!$model->validate()) {
            Yii::$app->response->statusCode = 422;
            return $model->getErrors();
        }
        // var_dump($model->getErrors());

        // if (Yii::$app->request->isPost) {
        //     $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

        //     $upload = $model->upload();
        //     if ($upload) {
        //         return $this->asJson([
        //             'path' => $upload
        //         ]);
        //     }
        //     var_dump($upload);
        // }


        Yii::$app->response->statusCode = 400;

        return $model->getErrors() ?? ['message' => 'You have error'];
    }
}
