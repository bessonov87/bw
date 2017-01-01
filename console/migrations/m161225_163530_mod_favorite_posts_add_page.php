<?php

use yii\db\Migration;

class m161225_163530_mod_favorite_posts_add_page extends Migration
{
    public $tableName = '{{%favorite_posts}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'page_hash', $this->string(32));

        $this->createIndex('favorite_posts_page_hash_idx', $this->tableName, 'page_hash');
    }

    public function safeDown()
    {
        $this->dropIndex('favorite_posts_page_hash_idx', $this->tableName);

        $this->dropColumn($this->tableName, 'page_hash');
    }
}
