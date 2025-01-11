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
        ]);

        $this->addForeignKey('fk-advertisements-product_id', 'advertisements', 'product_id', 'products', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advertisements-product_id', 'advertisements_properties');

        $this->dropTable('{{%advertisements}}');
    }
}
