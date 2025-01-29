<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertisement}}`.
 */
class m250111_213052_create_advertisements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertisements}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'price' => $this->integer(),
            'description' => $this->text(),
            'is_show' => $this->boolean(),
            'is_new' => $this->boolean(),
            'product_id' => $this->integer()->notNull(),
            'office_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk-advertisements-product_id', 'advertisements', 'product_id', 'products', 'id', 'CASCADE');
        $this->addForeignKey('fk-advertisements-office_id', 'advertisements', 'office_id', 'offices', 'id', 'CASCADE');
        $this->addForeignKey('fk-advertisements-user_id', 'advertisements', 'user_id', 'users', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-advertisements-product_id', 'advertisements_properties');
        $this->dropForeignKey('fk-advertisements-office_id', 'advertisements_properties');
        $this->dropForeignKey('fk-advertisements-user_id', 'advertisements_properties');

        $this->dropTable('{{%advertisements}}');
    }
}
