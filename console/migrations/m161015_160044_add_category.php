<?php

use yii\db\Migration;

class m161015_160044_add_category extends Migration
{
    public $tableName = '{{%category}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'parent_id' => $this->bigInteger()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'icon' => $this->string(),
            'description' => $this->text(),
            'meta_title' => $this->string(),
            'meta_descr' => $this->string(),
            'meta_keywords' => $this->string(),
            'post_sort' => $this->string(),
            'post_num' => $this->smallInteger()->notNull()->defaultValue(0),
            'short_view' => $this->string(),
            'full_view' => $this->string(),
            'category_art' => $this->bigInteger(),
            'header' => $this->text(),
            'footer' => $this->text(),
            'add_method' => $this->string(),
        ]);

        $this->createIndex('category_parent_id_idx', $this->tableName, 'parent_id');
        $this->createIndex('category_url_idx', $this->tableName, 'url');
    }

    public function safeDown()
    {
        $this->dropIndex('category_url_idx', $this->tableName);
        $this->dropIndex('category_parent_id_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
