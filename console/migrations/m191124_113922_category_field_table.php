<?php

use yii\db\Migration;

class m191124_113922_category_field_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category_field}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'field_id' => $this->integer()->notNull(),
            'depth' => $this->integer()->defaultValue(0),
            'filter' => $this->integer()->notNull(),
            'list' => $this->integer()->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('category_id', '{{%category_field}}', 'category_id', false);
        $this->addForeignKey("category_field_category_fk", "{{%category_field}}", "category_id", "{{%category}}", "id", 'CASCADE');

        $this->createIndex('field_id', '{{%category_field}}', 'field_id', false);
        $this->addForeignKey("category_field_field_fk", "{{%category_field}}", "field_id", "{{%field}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%category_field}}');
    }
}
