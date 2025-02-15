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
            [['mark', 'text', 'reviewtable_id', 'reviewtable_type', 'user_id'], 'required'],
            [['mark', 'reviewtable_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['text', 'reviewtable_type'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
}
