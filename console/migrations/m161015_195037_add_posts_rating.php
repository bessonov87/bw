<?php

use yii\db\Migration;

class m161015_195037_add_posts_rating extends Migration
{
    public $tableName = '{{%posts_rating}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'post_id' => $this->bigInteger()->notNull(),
            'user_id' => $this->bigInteger()->notNull(),
            'score' => $this->smallInteger()->notNull()->defaultValue(1),
        ]);

        $this->addForeignKey('posts_rating_post_id_fk', $this->tableName, 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('posts_rating_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('posts_rating_score_idx', $this->tableName, 'score');
    }

    public function safeDown()
    {
        $this->dropIndex('posts_rating_score_idx', $this->tableName);

        $this->dropForeignKey('posts_rating_user_id_fk', $this->tableName);
        $this->dropForeignKey('posts_rating_post_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
