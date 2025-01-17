<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisement_properties}}`.
 */
class m250111_213232_create_advertisement_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisement_properties}}', [
            'id' => $this->primaryKey(),
            'product_property_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-advertisement_properties-product_property_id', 'advertisement_properties', 'product_property_id', 'product_properties', 'id', 'CASCADE');
        $this->addForeignKey('fk-advertisement_properties-advertisement_id', 'advertisement_properties', 'advertisement_id', 'advertisements', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advertisement_properties-product_property_id', 'advertisement_properties');
        $this->dropForeignKey('fk-advertisement_properties-advertisement_id', 'advertisement_properties');

        $this->dropTable('{{%advertisement_properties}}');
    }
}
