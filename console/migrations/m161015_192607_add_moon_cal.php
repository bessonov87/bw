<?php

use yii\db\Migration;

class m161015_192607_add_moon_cal extends Migration
{
    public $tableName = '{{%moon_cal}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'date' => $this->date()->notNull(),
            'moon_day' => $this->smallInteger()->notNull(),
            'moon_day_from' => $this->time()->notNull(),
            'moon_day_sunset' => $this->time()->notNull(),
            'moon_day2' => $this->smallInteger()->notNull()->defaultValue(0),
            'moon_day2_from' => $this->time()->notNull(),
            'moon_day2_sunset' => $this->time()->notNull(),
            'zodiak' => $this->smallInteger()->notNull(),
            'zodiak_from_ut' => $this->time()->notNull(),
            'phase' => $this->smallInteger()->notNull(),
            'phase_from' => $this->time()->notNull(),
            'moon_percent' => $this->float()->notNull(),
            'blago' => $this->smallInteger()->notNull()
        ]);

        $this->createIndex('moon_cal_date_idx', $this->tableName, 'date');
        $this->createIndex('moon_cal_moon_day_idx', $this->tableName, 'moon_day');
        $this->createIndex('moon_cal_zodiak_idx', $this->tableName, 'zodiak');
        $this->createIndex('moon_cal_phase_idx', $this->tableName, 'phase');
        $this->createIndex('moon_cal_moon_percent_idx', $this->tableName, 'moon_percent');
        $this->createIndex('moon_cal_blago_idx', $this->tableName, 'blago');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_cal_blago_idx', $this->tableName);
        $this->dropIndex('moon_cal_moon_percent_idx', $this->tableName);
        $this->dropIndex('moon_cal_phase_idx', $this->tableName);
        $this->dropIndex('moon_cal_zodiak_idx', $this->tableName);
        $this->dropIndex('moon_cal_moon_day_idx', $this->tableName);
        $this->dropIndex('moon_cal_date_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
