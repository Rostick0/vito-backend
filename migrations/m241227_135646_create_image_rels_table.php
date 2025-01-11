<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_rel}}`.
 */
class m241227_135646_create_image_rels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_rels}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
            'reltable_id' => $this->integer()->notNull(),
            'reltable_type' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-image_rels-image_id', 'image_rels', 'image_id', 'images', 'id', 'CASCADE');
        $this->createIndex('image_rels_image_relstable_type_image_relstable_id_index', 'image_rels', ['reltable_id', 'reltable_type']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('k-image_rels-image_id', 'image_rels');
        $this->dropIndex('image_rels_image_relstable_type_image_relstable_id_index', 'image_rels');

        $this->dropTable('{{%image_rel}}');
    }
}
