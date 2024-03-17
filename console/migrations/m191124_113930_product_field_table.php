<?php

use yii\db\Migration;

class m191124_113930_product_field_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_field}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'field_id' => $this->integer()->notNull(),
            'value' => $this->text()->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('product_id', '{{%product_field}}', 'product_id', false);
        $this->addForeignKey("product_field_product_fk", "{{%product_field}}", "product_id", "{{%product}}", "id", 'CASCADE');

        $this->createIndex('field_id', '{{%product_field}}', 'field_id', false);
        $this->addForeignKey("product_field_field_fk", "{{%product_field}}", "field_id", "{{%field}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%product_field}}');
    }
}
