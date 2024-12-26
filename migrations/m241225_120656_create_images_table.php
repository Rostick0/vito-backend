<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m241225_120656_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),
            'path_webp' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
