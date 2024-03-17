<?php

use yii\db\Migration;

class m191124_113940_map_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%map}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'parent_id' => $this->integer()->null(),
            'sort_order' => $this->integer()->defaultValue(0),
            'page_id' => $this->integer()->null(),
            'controller' => $this->string()->null(),
            'action' => $this->string()->null(),

            'slug' => $this->string()->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('parent_id', '{{%map}}', 'parent_id', false);
        $this->addForeignKey("menu_menu_fk", "{{%map}}", "parent_id", "{{%map}}", "id", 'CASCADE');

        $this->createIndex('page_id', '{{%map}}', 'page_id', false);
        $this->addForeignKey("menu_page_fk", "{{%map}}", "page_id", "{{%page}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%map}}');
    }
}
