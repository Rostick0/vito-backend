<?php

namespace app\controllers;

use app\models\Image;
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
        $image_form = new ImageForm();
        $image_form->imageFile = UploadedFile::getInstanceByName('imageFile');

        if (!$image_form->validate()) {
            Yii::$app->response->setStatusCode(422);
            return $image_form->getErrors();
        }


        $upload = $image_form->upload();
        if ($upload) {
            $image = new Image();

            $image->load(['path' => $upload], '');
            $image->save();

            return $image;
        }


        Yii::$app->response->statusCode = 400;

        return ['message' => 'You have error'];
    }
}
