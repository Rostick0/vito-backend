<?php

namespace app\models\request;

use yii\base\Model;
use yii\helpers\FileHelper;

class ImageForm extends Model
{
    public $imageFile;

    public function rules()
    {
        return [
            ['imageFile', 'required'],
            [['imageFile'], 'image', 'skipOnEmpty' => false,]
        ];
    }

    public function upload()
    {
        $path_upload =  'uploads/images/';
        $path_with_date = \Lcobucci\Clock\SystemClock::fromUTC()->now()->format('Y/m/d');

        FileHelper::createDirectory($path_upload . $path_with_date);
        $file_path = $path_upload . $path_with_date . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->imageFile->saveAs($file_path);

        return \yii\helpers\Url::base(true) . '/' . $file_path;
    }
}
