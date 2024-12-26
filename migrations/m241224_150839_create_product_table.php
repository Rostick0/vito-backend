<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m241224_150839_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' => $this->float(),
            'is_show' => $this->boolean()->defaultValue(0),
            'category_id' => $this->integer(),
            'created_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('fk-product-category_id', 'product', 'category_id', 'category', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product-category_id', 'product');

        $this->dropTable('{{%product}}');
    }
}
