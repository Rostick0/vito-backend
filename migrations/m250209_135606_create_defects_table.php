<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%defects}}`.
 */
class m250209_135606_create_defects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%defects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'defect_type_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-defects-defect_type_id', 'defects', 'defect_type_id', 'defect_types', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-defects-defect_type_id', 'defects');

        $this->dropTable('{{%defects}}');
    }
}
