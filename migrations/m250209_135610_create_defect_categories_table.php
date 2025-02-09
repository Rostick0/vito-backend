<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%defect_categories}}`.
 */
class m250209_135610_create_defect_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%defect_categories}}', [
            'id' => $this->primaryKey(),
            'defect_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-defect_categories-defect_id', 'defect_categories', 'defect_id', 'defects', 'id', 'CASCADE');
        $this->addForeignKey('fk-defect_categories-category_id', 'defect_categories', 'category_id', 'categories', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-defect_categories-defect_id', 'defect_categories');
        $this->dropForeignKey('fk-defect_categories-category_id', 'defect_categories');

        $this->dropTable('{{%defect_categories}}');
    }
}
