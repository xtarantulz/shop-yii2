<?php

use yii\db\Migration;

class m191124_113942_config_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'region' => $this->string()->notNull(),
            'country' => $this->string()->notNull(),

            'h1_main_page' => $this->string()->notNull(),
            'slider_main_page' => $this->text()->notNull(),
            'footer_description' => $this->text()->notNull(),

            'updated_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->insert($this->db->tablePrefix.'config', [
            'email' => 'suport@gmail.com',
            'phone' => '+38 (063) 27-00-652',
            'address' => 'вул. Ботанічна 25',
            'city' => 'Житомир',
            'region' => 'Житомирська',
            'country' => 'Україна',

            'h1_main_page' => "Тестова галерея",
            'slider_main_page' => '/img/slider/1.jpg, /img/slider/3.jpg',
            'footer_description' => "Завтра магна ненависть Ліл розминки відповідати його носі Tierra. Justo Eget iaculis нада, земля розминка, щоб побачити великий футбол не мають моря, в діаметрі гранту phasellus derita Валі DART. Теплий шоколад рецепти фінансування мікрохвильового холодильника. Mauris в даний час основні вихідних по всій країні.",

            'updated_at' => time(),
            'created_at' => time()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
