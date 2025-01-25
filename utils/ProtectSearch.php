<?php

namespace app\utils;

class ProtectSearch
{
    public static function issetAttribute(string $key, \yii\db\ActiveQuery $query)
    {
        return array_search($key, self::getModelAttributes($query)) !== false;
    }

    public static function getModelAttributes(\yii\db\ActiveQuery $query)
    {
        return array_keys((new $query->modelClass)->getAttributes());
    }
}
