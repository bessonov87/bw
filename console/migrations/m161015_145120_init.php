<?php

use yii\db\Migration;

class m161015_145120_init extends Migration
{
    public $tableName = '{{%user}}';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email_confirm_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'user_group' => $this->smallInteger()->notNull()->defaultValue(4),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
            'last_login_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('user_status_idx', $this->tableName, 'status');
        $this->createIndex('user_user_group_idx', $this->tableName, 'user_group');
        $this->createIndex('user_created_at_idx', $this->tableName, 'created_at');

        $this->insert($this->tableName, [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'OTI2MGJlYzdmZTIwYzJkNzk1NGFmNzMz',
            'password_hash' => '$2y$13$CVNvxvC04LBKVjKZRLF0KuenzPlUjQroHKY7M968.qbO92yUf2Pya',
            'email' => 'weblon@inbox.ru',
            'status' => 10,
            'user_group' => 1,
            'created_at' => 1236162404,
            'updated_at' => 1236162404
        ]);
    }
    public function down()
    {
        $this->dropIndex('user_created_at_idx', $this->tableName);
        $this->dropIndex('user_user_group_idx', $this->tableName);
        $this->dropIndex('user_status_idx', $this->tableName);

        $this->dropTable('{{%user}}');
    }
}
