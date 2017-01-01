<?php

use yii\db\Migration;

class m161225_144030_mod_moon_hair_add_days extends Migration
{
    public $tableName = '{{%moon_hair}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'days', 'json');
    }

    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'days');
    }
}
