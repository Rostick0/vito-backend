<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisement_defects}}`.
 */
class m250209_135611_create_advertisement_defects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisement_defects}}', [
            'id' => $this->primaryKey(),
            'defect_id' => $this->integer()->notNull(),
            'advertisement_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-advertisement_defects-defect_id', 'advertisement_defects', 'defect_id', 'defects', 'id', 'CASCADE');
        $this->addForeignKey('fk-advertisement_defects-advertisement_id', 'advertisement_defects', 'advertisement_id', 'advertisements', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advertisement_defects-defect_id', 'advertisement_defects');
        $this->dropForeignKey('fk-advertisement_defects-advertisement_id', 'advertisement_defects');

        $this->dropTable('{{%advertisement_defects}}');
    }
}
