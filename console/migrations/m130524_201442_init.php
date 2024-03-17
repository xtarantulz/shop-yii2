<?php

use yii\db\Migration;
use common\models\User;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string()->null(),
            'photo' => $this->string()->null(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'role' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert($this->db->tablePrefix.'user', [
            'email' => 'admin@gmail.com',
            'first_name' => 'Адмін',
            'last_name' => 'Адмінко',
            'middle_name' => 'Адміновіч',
            'password_hash' => '$2y$13$Uyc6y1S0H7vDZaWej3is/.aA36J6oWqvFVBScWamBUPRMMhTSpFUK',
            'auth_key' => '4235ewvsd432rwsfwd432rw',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN,
            'updated_at' => time(),
            'created_at' => time()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
