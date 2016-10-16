<?php

use yii\db\Migration;

class m161015_193328_add_moon_dni extends Migration
{
    public $tableName = '{{%moon_dni}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'num' => $this->smallInteger()->notNull(),
            'text' => $this->text()->notNull(),
            'blago' => $this->smallInteger()->notNull()
        ]);

        $this->createIndex('moon_dni_num_idx', $this->tableName, 'num');
        $this->createIndex('moon_dni_blago_idx', $this->tableName, 'blago');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_dni_blago_idx', $this->tableName);
        $this->dropIndex('moon_dni_num_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
