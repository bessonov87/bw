<?php

use yii\db\Migration;

class m170121_212312_add_products_category extends Migration
{
    public $tableName = '{{%products_category}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
        ]);

        $this->createIndex('products_category_name_idx', $this->tableName, 'name');
        $this->createIndex('products_category_url_idx', $this->tableName, 'url');
    }

    public function safeDown()
    {
        $this->dropIndex('products_category_url_idx', $this->tableName);
        $this->dropIndex('products_category_name_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
