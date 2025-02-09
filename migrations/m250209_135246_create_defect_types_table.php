<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%defect_types}}`.
 */
class m250209_135246_create_defect_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%defect_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%defect_types}}');
    }
}
