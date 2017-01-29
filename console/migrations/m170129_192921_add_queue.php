<?php

use yii\db\Migration;

class m170129_192921_add_queue extends Migration
{
    public $tableName = '{{%queue}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'taskData' => 'json NOT NULL',
            'priority' => $this->smallInteger()->defaultValue(5),
            'taskType' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'message' => $this->string(),
        ]);

        $this->createIndex('queue_priority_idx', $this->tableName, 'priority');
        $this->createIndex('queue_taskType_idx', $this->tableName, 'taskType');
        $this->createIndex('queue_created_at_idx', $this->tableName, 'created_at');
        $this->createIndex('queue_updated_at_idx', $this->tableName, 'updated_at');
        $this->createIndex('queue_status_idx', $this->tableName, 'status');
    }

    public function safeDown()
    {
        $this->dropIndex('queue_status_idx', $this->tableName);
        $this->dropIndex('queue_updated_at_idx', $this->tableName);
        $this->dropIndex('queue_created_at_idx', $this->tableName);
        $this->dropIndex('queue_taskType_idx', $this->tableName);
        $this->dropIndex('queue_priority_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
