<?php

use yii\db\Migration;

class m191124_113945_order_item_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->null(),
            'product_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'price' =>  $this->decimal(10, 2)->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('order_id', '{{%order_item}}', 'order_id', false);
        $this->addForeignKey("order_item_order_fk", "{{%order_item}}", "order_id", "{{%order}}", "id", 'CASCADE');

        $this->createIndex('product_id', '{{%order_item}}', 'product_id', false);
        $this->addForeignKey("order_item_product_fk", "{{%order_item}}", "product_id", "{{%product}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%order_item}}');
    }
}
