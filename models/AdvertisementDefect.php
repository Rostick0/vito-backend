<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertisement_defects".
 *
 * @property int $id
 * @property int $defect_id
 * @property int $advertisement_id
 *
 * @property Advertisement $advertisement
 * @property Defect $defect
 */
class AdvertisementDefect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement_defects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['defect_id', 'advertisement_id'], 'required'],
            [['defect_id', 'advertisement_id'], 'integer'],
            [['advertisement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::class, 'targetAttribute' => ['advertisement_id' => 'id']],
            [['defect_id'], 'exist', 'skipOnError' => true, 'targetClass' => Defect::class, 'targetAttribute' => ['defect_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'defect_id' => 'Defect ID',
            'advertisement_id' => 'Advertisement ID',
        ];
    }

    public function extraFields()
    {
        return ['advertisement', 'defect'];
    }

    /**
     * Gets query for [[Advertisement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisement()
    {
        return $this->hasOne(Advertisement::class, ['id' => 'advertisement_id']);
    }

    /**
     * Gets query for [[Defect]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDefect()
    {
        return $this->hasOne(Defect::class, ['id' => 'defect_id']);
    }
}
