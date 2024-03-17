<?php

use yii\db\Migration;

class m191124_113944_order_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'total' => $this->decimal(10, 2)->notNull(),
            'status' => $this->integer()->defaultValue(0),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('user_id', '{{%order}}', 'user_id', false);
        $this->addForeignKey("order_user_fk", "{{%order}}", "user_id", "{{%user}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%order}}');
    }
}
