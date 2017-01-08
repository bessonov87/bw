<?php

use yii\db\Migration;

class m170102_154012_add_goroskop extends Migration
{
    public $tableName = '{{%goroskop}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'zodiak' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'text' => $this->text()->notNull(),
            'date' => $this->date(),
            'week' => $this->smallInteger()->notNull()->defaultValue(0),
            'month' => $this->smallInteger()->notNull()->defaultValue(0),
            'year' => $this->smallInteger()->notNull(),
            'period' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'approve' => $this->smallInteger()->notNull()->defaultValue(0),
            'views' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('goroskop_zodiak_idx', $this->tableName, 'zodiak');
        $this->createIndex('goroskop_created_at_idx', $this->tableName, 'created_at');
        $this->createIndex('goroskop_date_idx', $this->tableName, 'date');
        $this->createIndex('goroskop_week_idx', $this->tableName, 'week');
        $this->createIndex('goroskop_month_idx', $this->tableName, 'month');
        $this->createIndex('goroskop_year_idx', $this->tableName, 'year');
        $this->createIndex('goroskop_period_idx', $this->tableName, 'period');
        $this->createIndex('goroskop_type_idx', $this->tableName, 'type');
        $this->createIndex('goroskop_approve_idx', $this->tableName, 'approve');
        $this->createIndex('goroskop_views_idx', $this->tableName, 'views');
    }

    public function safeDown()
    {
        $this->dropIndex('goroskop_views_idx', $this->tableName);
        $this->dropIndex('goroskop_approve_idx', $this->tableName);
        $this->dropIndex('goroskop_type_idx', $this->tableName);
        $this->dropIndex('goroskop_period_idx', $this->tableName);
        $this->dropIndex('goroskop_year_idx', $this->tableName);
        $this->dropIndex('goroskop_month_idx', $this->tableName);
        $this->dropIndex('goroskop_week_idx', $this->tableName);
        $this->dropIndex('goroskop_date_idx', $this->tableName);
        $this->dropIndex('goroskop_created_at_idx', $this->tableName);
        $this->dropIndex('goroskop_zodiak_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
