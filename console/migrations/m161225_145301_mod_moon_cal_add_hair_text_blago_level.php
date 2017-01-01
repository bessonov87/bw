<?php

use yii\db\Migration;

class m161225_145301_mod_moon_cal_add_hair_text_blago_level extends Migration
{
    public $tableName = '{{%moon_cal}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'hair_text', $this->string());
        $this->addColumn($this->tableName, 'blago_level', $this->smallInteger()->notNull()->defaultValue(0));

        $this->createIndex('moon_cal_blago_level_idx', $this->tableName, 'blago_level');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_cal_blago_level_idx', $this->tableName);

        $this->dropColumn($this->tableName, 'blago_level');
        $this->dropColumn($this->tableName, 'hair_text');
    }
}
