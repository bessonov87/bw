<?php

use yii\db\Migration;

class m161015_160112_add_post extends Migration
{
    public $tableName = '{{%post}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'author_id' => $this->bigInteger()->notNull(),
            'date' => $this->integer()->notNull(),
            'category_id' => $this->bigInteger()->notNull(),
            'short' => $this->text()->notNull(),
            'full' => $this->text()->notNull(),
            'title' => $this->string()->notNull(),
            'meta_title' => $this->string(),
            'meta_descr' => $this->string(),
            'meta_keywords' => $this->string(),
            'url' => $this->string()->notNull(),
            'related' => $this->string(),
            'prev_page' => $this->bigInteger(),
            'next_page' => $this->bigInteger(),
            'views' => $this->bigInteger()->notNull()->defaultValue(0),
            'edit_date' => $this->integer()->notNull()->defaultValue(0),
            'edit_user' => $this->bigInteger(),
            'edit_reason' => $this->string(),
            'allow_comm' => $this->smallInteger()->notNull()->defaultValue(1),
            'allow_main' => $this->smallInteger()->notNull()->defaultValue(1),
            'allow_catlink' => $this->smallInteger()->notNull()->defaultValue(1),
            'allow_similar' => $this->smallInteger()->notNull()->defaultValue(1),
            'allow_rate' => $this->smallInteger()->notNull()->defaultValue(1),
            'allow_ad' => $this->smallInteger()->notNull()->defaultValue(1),
            'approve' => $this->smallInteger()->notNull()->defaultValue(0),
            'fixed' => $this->smallInteger()->notNull()->defaultValue(0),
            'category_art' => $this->smallInteger()->notNull()->defaultValue(0),
            'inm' => $this->smallInteger()->notNull()->defaultValue(0),
            'not_in_related' => $this->smallInteger()->notNull()->defaultValue(0),
            'skin' => $this->smallInteger(),
        ]);

        $this->addForeignKey('post_author_id_fk', $this->tableName, 'author_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('post_category_id_fk', $this->tableName, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('post_date_idx', $this->tableName, 'date');
        $this->createIndex('post_url_idx', $this->tableName, 'url');
        $this->createIndex('post_views_idx', $this->tableName, 'views');
        $this->createIndex('post_allow_main_idx', $this->tableName, 'allow_main');
        $this->createIndex('post_approve_idx', $this->tableName, 'approve');
        $this->createIndex('post_fixed_idx', $this->tableName, 'fixed');
        $this->createIndex('post_category_art_idx', $this->tableName, 'category_art');
    }

    public function safeDown()
    {
        $this->dropIndex('post_category_art_idx', $this->tableName);
        $this->dropIndex('post_fixed_idx', $this->tableName);
        $this->dropIndex('post_approve_idx', $this->tableName);
        $this->dropIndex('post_allow_main_idx', $this->tableName);
        $this->dropIndex('post_views_idx', $this->tableName);
        $this->dropIndex('post_url_idx', $this->tableName);
        $this->dropIndex('post_date_idx', $this->tableName);

        $this->dropPrimaryKey('post_category_id_fk', $this->tableName);
        $this->dropPrimaryKey('post_author_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
