<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_properties}}`.
 */
class m250109_203846_create_product_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_properties}}', [
            'id' => $this->primaryKey(),
            'value' => $this->integer(),
            'property_id' => $this->integer()->notNull(),
            'property_value_id' => $this->integer(),
            'product_id' => $this->integer()->notNull(),
            'is_specified' => $this->boolean(),
        ]);

        $this->addForeignKey('fk-product_properties-property_id', 'product_properties', 'property_id', 'properties', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_properties-property_value_id', 'product_properties', 'property_value_id', 'property_values', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_properties-product_id', 'product_properties', 'product_id', 'products', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_properties-property_id', 'product_properties');
        $this->dropForeignKey('fk-product_properties-property_value_id', 'product_properties');
        $this->dropForeignKey('fk-product_properties-product_id', 'product_properties');

        $this->dropTable('{{%product_properties}}');
    }
}
