<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $mark
 * @property string $text
 * @property int $reviewtable_id
 * @property string $reviewtable_type
 * @property int $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark', 'text', 'reviewtable_id', 'reviewtable_type'], 'required'],
            [['reviewtable_id'], 'integer'],
            [['mark'], 'integer', 'min' => 1, 'max' => 5],
            [['created_at'], 'safe'],
            [['text', 'reviewtable_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark' => 'Mark',
            'text' => 'Text',
            'reviewtable_id' => 'Reviewtable ID',
            'reviewtable_type' => 'Reviewtable Type',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function extraFields()
    {
        return ['user'];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = Yii::$app->user->id;
            } else {
                $this->updated_at = (new \DateTimeImmutable())->format("Y-m-d H:i:s");
            }

            return true;
        }

        return false;
    }
}
