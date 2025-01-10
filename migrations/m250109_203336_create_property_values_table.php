<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_values}}`.
 */
class m250109_203336_create_property_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_values}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull(),
            'property_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-property_values-property_id', 'property_values', 'property_id', 'properties', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-property_values-property_id', 'property_values');

        $this->dropTable('{{%property_values}}');
    }
}
