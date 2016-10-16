<?php

use yii\db\Migration;

class m161015_194546_add_moon_ogorod extends Migration
{
    public $tableName = '{{%moon_ogorod}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'month' => $this->smallInteger()->notNull(),
            'zodiak' => $this->smallInteger()->notNull(),
            'phase' => $this->smallInteger()->notNull(),
            'text' => $this->text()->notNull()
        ]);

        $this->createIndex('moon_ogorod_month_idx', $this->tableName, 'month');
        $this->createIndex('moon_ogorod_zodiak_idx', $this->tableName, 'zodiak');
        $this->createIndex('moon_ogorod_phase_idx', $this->tableName, 'phase');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_ogorod_phase_idx', $this->tableName);
        $this->dropIndex('moon_ogorod_zodiak_idx', $this->tableName);
        $this->dropIndex('moon_ogorod_month_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
