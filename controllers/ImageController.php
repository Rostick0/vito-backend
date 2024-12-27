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
        // dd(Yii::$app->urlManager->createAbsoluteUrl(''));
        $model->imageFile = UploadedFile::getInstanceByName('imageFile');

        // dd($model);
        // $model->load(Yii::$app->request->post(), '');
        // dd(UploadedFile::getInstance($model, 'imageFile'));
        // dd($model->imageFile);
        // $model->load(Yii::$app->request->post(), '');

        if (!$model->validate()) {
            Yii::$app->response->statusCode = 422;
            return $model->getErrors();
        }

        if (Yii::$app->request->isPost) {

            $upload = $model->upload();
            // dd($upload);
            if ($upload) {
                return [
                    'path' => $upload
                ];
            }
        }


        Yii::$app->response->statusCode = 400;

        return ['message' => 'You have error'];
    }
}
