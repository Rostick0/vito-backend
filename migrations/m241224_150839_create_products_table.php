<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m241224_150839_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' => $this->float(),
            'is_show' => $this->boolean()->defaultValue(0),
            'category_id' => $this->integer(),
            'created_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk-products-category_id', 'products', 'category_id', 'categories', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', 'products');

        $this->dropTable('{{%products}}');
    }
}
