<?php

namespace app\controllers;

use app\models\Office;
use yii\rest\ActiveController;
use Yii;

class OfficeController extends ActiveController
{
    public $modelClass = Office::class;
}
