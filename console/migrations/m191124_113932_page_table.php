<?php

use yii\db\Migration;

class m191124_113932_page_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique()->notNull(),
            'content' => $this->text()->notNull(),

            'seo_title' => $this->string()->null(),
            'seo_keywords' => $this->text()->null(),
            'seo_description' => $this->text()->null(),

            'slug' => $this->string()->unique()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
    }
}
