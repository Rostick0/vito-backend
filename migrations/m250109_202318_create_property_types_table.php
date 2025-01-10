<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_types}}`.
 */
class m250109_202318_create_property_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%property_types}}');
    }
}
