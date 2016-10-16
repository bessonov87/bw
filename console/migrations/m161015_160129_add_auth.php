<?php

use yii\db\Migration;

class m161015_160129_add_auth extends Migration
{
    public $tableName = '{{%auth}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('auth_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('auth_source_idx', $this->tableName, 'source');
        $this->createIndex('auth_source_id_idx', $this->tableName, 'source_id');
    }

    public function safeDown()
    {
        $this->dropIndex('auth_source_id_idx', $this->tableName);
        $this->dropIndex('auth_source_idx', $this->tableName);

        $this->dropForeignKey('auth_user_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
