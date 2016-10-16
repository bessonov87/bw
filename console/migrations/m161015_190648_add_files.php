<?php

use yii\db\Migration;

class m161015_190648_add_files extends Migration
{
    public $tableName = '{{%files}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'post_id' => $this->bigInteger()->notNull(),
            'r_id' => $this->string(6),
            'name' => $this->string()->notNull(),
            'folder' => $this->string(),
            'size' => $this->integer()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'date' => $this->integer()->notNull(),
            'download_count' => $this->integer()->notNull()->defaultValue(0)
        ]);

        $this->addForeignKey('files_post_id_fk', $this->tableName, 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('files_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('files_r_id_idx', $this->tableName, 'r_id');
        $this->createIndex('files_name_idx', $this->tableName, 'name');
        $this->createIndex('files_size_idx', $this->tableName, 'size');
        $this->createIndex('files_date_idx', $this->tableName, 'date');
        $this->createIndex('files_download_count_idx', $this->tableName, 'download_count');
    }

    public function safeDown()
    {
        $this->dropIndex('files_download_count_idx', $this->tableName);
        $this->dropIndex('files_date_idx', $this->tableName);
        $this->dropIndex('files_size_idx', $this->tableName);
        $this->dropIndex('files_name_idx', $this->tableName);
        $this->dropIndex('files_r_id_idx', $this->tableName);

        $this->dropForeignKey('files_user_id_fk', $this->tableName);
        $this->dropForeignKey('files_post_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
