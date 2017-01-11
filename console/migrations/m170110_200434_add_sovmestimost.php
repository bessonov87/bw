<?php

use yii\db\Migration;

class m170110_200434_add_sovmestimost extends Migration
{
    public $tableName = '{{%sovmestimost}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'man' => $this->smallInteger()->notNull(),
            'woman' => $this->smallInteger()->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('sovmestimost_man_fkey', $this->tableName, 'man', '{{%znaki_zodiaka}}', 'znak_id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('sovmestimost_woman_fkey', $this->tableName, 'woman', '{{%znaki_zodiaka}}', 'znak_id', 'CASCADE', 'CASCADE');

        $this->createIndex('sovmestimost_man_woman_idx', $this->tableName, ['man', 'woman'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('sovmestimost_man_woman_idx', $this->tableName);

        $this->dropForeignKey('sovmestimost_woman_fkey', $this->tableName);
        $this->dropForeignKey('sovmestimost_man_fkey', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
