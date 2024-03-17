<?php

use yii\db\Migration;

class m191124_113922_product_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'image' => $this->string()->null(),
            'images' => $this->text()->null(),
            'category_id' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'description' => $this->text()->notNull(),

            'seo_title' => $this->string()->null(),
            'seo_keywords' => $this->text()->null(),
            'seo_description' => $this->text()->null(),

            'slug' => $this->string()->unique()->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('category_id', '{{%product}}', 'category_id', false);
        $this->addForeignKey("product_category_fk", "{{%product}}", "category_id", "{{%category}}", "id", 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
