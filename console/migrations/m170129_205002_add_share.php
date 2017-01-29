<?php

use yii\db\Migration;

class m170129_205002_add_share extends Migration
{
    public $tableName = '{{%share}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'url' => $this->string()->notNull()->unique(),
            'vk' => $this->integer()->notNull()->defaultValue(0),
            'ok' => $this->integer()->notNull()->defaultValue(0),
            'fa' => $this->integer()->notNull()->defaultValue(0),
            'go' => $this->integer()->notNull()->defaultValue(0),
            'mr' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('share_url_idx', $this->tableName, 'url');
        $this->createIndex('share_vk_idx', $this->tableName, 'vk');
        $this->createIndex('share_ok_idx', $this->tableName, 'ok');
        $this->createIndex('share_fa_idx', $this->tableName, 'fa');
        $this->createIndex('share_go_idx', $this->tableName, 'go');
        $this->createIndex('share_mr_idx', $this->tableName, 'mr');
        $this->createIndex('share_created_at_idx', $this->tableName, 'created_at');
        $this->createIndex('share_updated_at_idx', $this->tableName, 'updated_at');
    }

    public function safeDown()
    {
        $this->dropIndex('share_updated_at_idx', $this->tableName);
        $this->dropIndex('share_created_at_idx', $this->tableName);
        $this->dropIndex('share_mr_idx', $this->tableName);
        $this->dropIndex('share_go_idx', $this->tableName);
        $this->dropIndex('share_fa_idx', $this->tableName);
        $this->dropIndex('share_ok_idx', $this->tableName);
        $this->dropIndex('share_vk_idx', $this->tableName);
        $this->dropIndex('share_url_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
