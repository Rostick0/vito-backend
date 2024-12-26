<?php

namespace app\models\request;

use yii\base\Model;

class ImageForm extends Model
{
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'required', 'skipOnEmpty' => false,]
        ];
    }

    public function upload()
    {
        $file_path = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        $this->imageFile->saveAs($file_path);

        return $file_path;
    }
}
