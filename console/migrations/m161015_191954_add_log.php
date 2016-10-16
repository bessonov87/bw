<?php

use yii\db\Migration;

class m161015_191954_add_log extends Migration
{
    public $tableName = '{{%log}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'level' => $this->smallInteger()->notNull(),
            'category' => $this->string()->notNull(),
            'log_time' => $this->float()->notNull(),
            'prefix' => $this->string()->notNull(),
            'message' => $this->text(),
        ]);

        $this->createIndex('log_level_idx', $this->tableName, 'level');
        $this->createIndex('log_category_idx', $this->tableName, 'category');
        $this->createIndex('log_log_time_idx', $this->tableName, 'log_time');
    }

    public function safeDown()
    {
        $this->dropIndex('log_log_time_idx', $this->tableName);
        $this->dropIndex('log_category_idx', $this->tableName);
        $this->dropIndex('log_level_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
