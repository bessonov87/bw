<?php

use yii\db\Migration;

class m161015_161950_add_comment extends Migration
{
    public $tableName = '{{%comment}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'reply_to' => $this->bigInteger(),
            'post_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'date' => $this->integer()->notNull(),
            'text_raw' => $this->text()->notNull(),
            'text' => $this->text()->notNull(),
            'ip' => $this->string()->notNull(),
            'is_register' => $this->smallInteger()->notNull()->defaultValue(0),
            'approve' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey('comment_post_id_fk', $this->tableName, 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('comment_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('comment_reply_to_idx', $this->tableName, 'reply_to');
        $this->createIndex('comment_date_idx', $this->tableName, 'date');
        $this->createIndex('comment_is_register_idx', $this->tableName, 'is_register');
        $this->createIndex('comment_ip_idx', $this->tableName, 'ip');
        $this->createIndex('comment_approve_idx', $this->tableName, 'approve');
    }

    public function safeDown()
    {
        $this->dropIndex('comment_approve_idx', $this->tableName);
        $this->dropIndex('comment_ip_idx', $this->tableName);
        $this->dropIndex('comment_is_register_idx', $this->tableName);
        $this->dropIndex('comment_date_idx', $this->tableName);
        $this->dropIndex('comment_reply_to_idx', $this->tableName);

        $this->dropForeignKey('comment_user_id_fk', $this->tableName);
        $this->dropForeignKey('comment_post_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
