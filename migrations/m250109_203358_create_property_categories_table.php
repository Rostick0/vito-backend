<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_categories}}`.
 */
class m250109_203358_create_property_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_categories}}', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-property_categories-property_id', 'property_categories', 'property_id', 'properties', 'id', 'CASCADE');
        $this->addForeignKey('fk-property_categories-category_id', 'property_categories', 'category_id', 'categories', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-property_categories-property_id', 'property_categories');
        $this->dropForeignKey('fk-property_categories-category_id', 'property_categories');

        $this->dropTable('{{%property_categories}}');
    }
}
