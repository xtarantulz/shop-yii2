<?php

use yii\db\Migration;

class m191124_113911_field_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%field}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'options' => $this->text()->null(),
            'prefix' => $this->string()->null(),
            'suffix' => $this->string()->null(),
            'description' => $this->text()->null(),
            'number_after_point' => $this->integer()->null(),
            'expansions' => $this->text()->null(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%field}}');
    }
}
