<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_rels".
 *
 * @property int $id
 * @property int $image_id
 * @property int $reltable_id
 * @property string $reltable_type
 *
 * @property Image $image
 */
class ImageRel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_rels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'reltable_id', 'reltable_type'], 'required'],
            [['image_id', 'reltable_id'], 'integer'],
            [['reltable_type'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_id' => 'Image ID',
            'reltable_id' => 'Reltable ID',
            'reltable_type' => 'Reltable Type',
        ];
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image_id']);
    }
}
