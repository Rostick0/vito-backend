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
            'name' => $this->string()->notNull(),
            'raiting' => $this->float()->defaultValue(0),
            'category_id' => $this->integer()->notNull(),
            'vendor_id' => $this->integer()->notNull(),
            'is_show' => $this->boolean(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk-products-category_id', 'products', 'category_id', 'categories', 'id', 'CASCADE');
        $this->addForeignKey('fk-products-vendor_id', 'products', 'vendor_id', 'vendors', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', 'products');
        $this->dropForeignKey('fk-products-vendor_id', 'products');

        $this->dropTable('{{%products}}');
    }
}
