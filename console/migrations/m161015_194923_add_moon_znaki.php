<?php

use yii\db\Migration;

class m161015_194923_add_moon_znaki extends Migration
{
    public $tableName = '{{%moon_znaki}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'num' => $this->smallInteger()->notNull(),
            'text' => $this->text()->notNull(),
            'blago' => $this->smallInteger()->notNull()
        ]);

        $this->createIndex('moon_znaki_num_idx', $this->tableName, 'num');
        $this->createIndex('moon_znaki_blago_idx', $this->tableName, 'blago');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_znaki_blago_idx', $this->tableName);
        $this->dropIndex('moon_znaki_num_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
