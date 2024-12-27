<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_relat}}`.
 */
class m241227_135646_create_image_relat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_relat}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image_relat}}');
    }
}
