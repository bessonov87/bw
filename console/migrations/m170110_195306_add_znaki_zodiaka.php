<?php

use yii\db\Migration;

class m170110_195306_add_znaki_zodiaka extends Migration
{
    public $tableName = '{{%znaki_zodiaka}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'znak_id' => $this->smallInteger()->notNull()->unique(),
            'element' => $this->string()->notNull(),
            'planet' => $this->string()->notNull(),
            'opposite' => $this->string()->notNull(),
            'stone' => $this->string()->notNull(),
            'color' => $this->string()->notNull(),
            'compatibility' => $this->string()->notNull(),
            'common' => $this->text()->notNull(),
            'man' => $this->text()->notNull(),
            'woman' => $this->text()->notNull(),
            'child' => $this->text()->notNull(),
            'career' => $this->text()->notNull(),
            'health' => $this->text()->notNull(),
            'sex' => $this->text()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('znaki_zodiaka_znak_id_idx', $this->tableName, 'znak_id');
    }

    public function safeDown()
    {
        $this->dropIndex('znaki_zodiaka_znak_id_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
