<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendors}}`.
 */
class m241224_150805_create_vendors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vendors}}');
    }
}