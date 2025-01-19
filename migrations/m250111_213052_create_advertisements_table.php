<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisement}}`.
 */
class m250111_213052_create_advertisements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisements}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->integer(),
            'product_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk-advertisements-product_id', 'advertisements', 'product_id', 'products', 'id', 'CASCADE');
        $this->addForeignKey('fk-advertisements-user_id', 'advertisements', 'user_id', 'users', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advertisements-product_id', 'advertisements_properties');
        $this->dropForeignKey('fk-advertisements-user_id', 'advertisements_properties');

        $this->dropTable('{{%advertisements}}');
    }
}
