<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vendor_categories}}`.
 */
class m250109_203845_create_vendor_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vendor_categories}}', [
            'id' => $this->primaryKey(),
            'vendor_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-vendor_categories-vendor_id', 'vendor_categories', 'vendor_id', 'vendors', 'id', 'CASCADE');
        $this->addForeignKey('fk-vendor_categories-category_id', 'vendor_categories', 'category_id', 'categories', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-vendor_categories-property_id', 'vendor_categories');
        $this->dropForeignKey('fk-vendor_categories-category_id', 'vendor_categories');

        $this->dropTable('{{%vendor_categories}}');
    }
}
