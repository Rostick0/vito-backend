<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m250215_150405_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'mark' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'reviewtable_id' => $this->integer()->notNull(),
            'reviewtable_type' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('reviews_reviewstable_type_reviewstable_id_index', 'reviews', ['reviewtable_id', 'reviewtable_type']);
        $this->addForeignKey('fk-reviews-user_id', 'reviews', 'user_id', 'users', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('reviews_reviewstable_type_reviewstable_id_index', 'reviews');
        $this->dropForeignKey('fk-reviews-user_id', 'reviews');

        $this->dropTable('{{%reviews}}');
    }
}
