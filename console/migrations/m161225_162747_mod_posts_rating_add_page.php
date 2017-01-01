<?php

use yii\db\Migration;

class m161225_162747_mod_posts_rating_add_page extends Migration
{
    public $tableName = '{{%posts_rating}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'page_hash', $this->string(32));

        $this->createIndex('posts_rating_page_hash_idx', $this->tableName, 'page_hash');
    }

    public function safeDown()
    {
        $this->dropIndex('posts_rating_page_hash_idx', $this->tableName);

        $this->dropColumn($this->tableName, 'page_hash');
    }
}
