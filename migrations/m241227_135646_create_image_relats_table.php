<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_relats}}`.
 */
class m241227_135646_create_image_relats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_relats}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image_relats}}');
    }
}
