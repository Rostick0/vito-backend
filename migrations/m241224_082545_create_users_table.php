<?php

use app\enum\PropertyTypeEnum;
use app\utils\EnumFields;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m241224_082545_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->unique()->notNull(),
            'tel' => $this->string(),
            'password' => $this->string(),
            'raiting' => $this->float()->defaultValue(0),
            'is_confirm' => $this->boolean()->defaultValue(false),
            'role' => 'ENUM(' .  EnumFields::getValidateValues(UserRoleEnum::class, "'", "'") . ') NOT NULL DEFAULT ' . UserRoleEnum::default->value,
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
