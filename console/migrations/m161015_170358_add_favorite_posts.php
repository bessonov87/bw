<?php

use yii\db\Migration;

class m161015_170358_add_favorite_posts extends Migration
{
    public $tableName = '{{%favorite_posts}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->bigInteger()->notNull(),
            'post_id' => $this->bigInteger()->notNull(),
            'link' => $this->string(),
            'title' => $this->string(),
            'date' => $this->integer()->notNull(),
            'external' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey('favorite_posts_post_id_fk', $this->tableName, 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('favorite_posts_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('favorite_posts_date_idx', $this->tableName, 'date');
        $this->createIndex('favorite_posts_external_idx', $this->tableName, 'external');
    }

    public function safeDown()
    {
        $this->dropIndex('favorite_posts_external_idx', $this->tableName);
        $this->dropIndex('favorite_posts_date_idx', $this->tableName);

        $this->dropForeignKey('favorite_posts_user_id_fk', $this->tableName);
        $this->dropForeignKey('favorite_posts_post_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
