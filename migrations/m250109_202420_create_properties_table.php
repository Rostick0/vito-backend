<?php

use app\enum\PropertyTypeEnum;
use app\utils\EnumFields;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%properties}}`.
 */
class m250109_202420_create_properties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%properties}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => 'ENUM(' .  EnumFields::getValidateValues(PropertyTypeEnum::class, "'", "'") . ') NOT NULL', //$this->string()->notNull(), //checkbox,select,input
            'unit' => $this->string(),
            'property_type_id' => $this->integer()->notNull(),
            'is_filter' => $this->boolean()->defaultValue(false),
            'is_specified' => $this->boolean()->defaultValue(false),,
        ]);

        $this->addForeignKey('fk-properties-property_type_id', 'properties', 'property_type_id', 'property_types', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-properties-property_type_id', 'properties');

        $this->dropTable('{{%properties}}');
    }
}
