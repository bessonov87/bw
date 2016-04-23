<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email_confirm_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'user_group' => $this->smallInteger()->notNull()->defaultValue(4),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'last_login_at' => $this->integer(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
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

        /** ADVERT **/
        $this->createTable('{{%advert}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'block_number' => $this->smallInteger()->notNull()->unique(),
            'code' => $this->text()->notNull(),
            'location' => $this->string(10)->notNull(),
            'replacement_tag' => $this->string(20)->notNull()->defaultValue('none'),
            'category' => $this->smallInteger()->notNull()->defaultValue(0),
            'approve' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'on_request' => $this->smallInteger(1)->notNull()->defaultValue(0),
        ]);

        $this->insert('{{%advert}}', [
            'id' => 1,
            'title' => 'Google Adsense в статьях',
            'block_number' => 1,
            'code' => '<br>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- beauty-in-adapt -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6721896084353188"
     data-ad-slot="8510135144"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>',
            'location' => 'inside',
            'replacement_tag' => 'yandex',
            'approve' => 1,
        ]);

        /** AUTH **/
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer(11)->notNull()->unsigned(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        /** CATEGORY **/
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
