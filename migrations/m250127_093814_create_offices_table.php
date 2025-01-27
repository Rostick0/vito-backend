<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%offices}}`.
 */
class m250127_093814_create_offices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offices}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'latitude' => $this->float()->notNull(),
            'longitude' => $this->float()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%offices}}');
    }
}
