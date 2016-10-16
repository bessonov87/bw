<?php

use yii\db\Migration;

class m161015_193901_add_moon_hair extends Migration
{
    public $tableName = '{{%moon_hair}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'title' => $this->string()->notNull(),
            'date' => $this->string(20)->notNull(),
            'post_id' => $this->smallInteger()->notNull()->defaultValue(0),
            'month' => $this->smallInteger()->notNull(),
            'year' => $this->smallInteger()->notNull(),
            'short' => $this->text()->notNull(),
            'full' => $this->text()->notNull(),
            'approve' => $this->smallInteger()->notNull()->defaultValue(0),
            'views' => $this->integer()->notNull()->defaultValue(0)
        ]);

        $this->createIndex('moon_hair_date_idx', $this->tableName, 'date');
        $this->createIndex('moon_hair_post_id_idx', $this->tableName, 'post_id');
        $this->createIndex('moon_hair_month_idx', $this->tableName, 'month');
        $this->createIndex('moon_hair_year_idx', $this->tableName, 'year');
        $this->createIndex('moon_hair_approve_idx', $this->tableName, 'approve');
        $this->createIndex('moon_hair_views_idx', $this->tableName, 'views');
    }

    public function safeDown()
    {
        $this->dropIndex('moon_hair_views_idx', $this->tableName);
        $this->dropIndex('moon_hair_approve_idx', $this->tableName);
        $this->dropIndex('moon_hair_year_idx', $this->tableName);
        $this->dropIndex('moon_hair_month_idx', $this->tableName);
        $this->dropIndex('moon_hair_post_id_idx', $this->tableName);
        $this->dropIndex('moon_hair_date_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
