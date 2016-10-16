<?php

use yii\db\Migration;

class m161015_155702_add_advert extends Migration
{
    public $tableName = '{{%advert}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'block_number' => $this->smallInteger()->notNull(),
            'code' => $this->text()->notNull(),
            'location' => $this->string()->notNull(),
            'replacement_tag' => $this->string(20)->notNull()->defaultValue('none'),
            'category' => $this->smallInteger()->notNull()->defaultValue(0),
            'approve' => $this->smallInteger()->notNull()->defaultValue(0),
            'on_request' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('advert_block_number_idx', $this->tableName, 'block_number');
        $this->createIndex('advert_location_idx', $this->tableName, 'location');
        $this->createIndex('advert_replacement_tag_idx', $this->tableName, 'replacement_tag');
        $this->createIndex('advert_category_idx', $this->tableName, 'category');
        $this->createIndex('advert_approve_idx', $this->tableName, 'approve');
    }

    public function safeDown()
    {
        $this->dropIndex('advert_approve_idx', $this->tableName);
        $this->dropIndex('advert_category_idx', $this->tableName);
        $this->dropIndex('advert_replacement_tag_idx', $this->tableName);
        $this->dropIndex('advert_location_idx', $this->tableName);
        $this->dropIndex('advert_block_number_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
