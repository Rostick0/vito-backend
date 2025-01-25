<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string|null $path
 * @property string|null $path_webp
 *
 * @property ImageRel[] $imageRels
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'path_webp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'path_webp' => 'Path Webp',
        ];
    }

    public function extraFields()
    {
        return ['imageRels'];
    }

    /**
     * Gets query for [[ImageRels]].
     */
    public function getImageRels(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ImageRel::class, ['image_id' => 'id']);
    }
}
