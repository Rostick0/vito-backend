<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_refresh_tokens}}`.
 */
class m241227_183644_create_user_refresh_tokens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_refresh_tokens}}', [
            'user_refresh_tokenID' => $this->primaryKey(),
            'urf_userID' => $this->integer()->unsigned(),
            'urf_token' => $this->string(1000),
            'urf_ip' => $this->string(50),
            'urf_user_agent' => $this->string(1000),
            'urf_created' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_refresh_tokens}}');
    }
}
