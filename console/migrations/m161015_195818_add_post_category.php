<?php

use yii\db\Migration;

class m161015_195818_add_post_category extends Migration
{
    public $tableName = '{{%post_category}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'post_id' => $this->bigInteger()->notNull(),
            'category_id' => $this->bigInteger()->notNull(),
        ]);

        $this->addForeignKey('post_category_post_id_fk', $this->tableName, 'post_id', '{{%post}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('post_category_category_id_fk', $this->tableName, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('post_category_category_id_fk', $this->tableName);
        $this->dropForeignKey('post_category_post_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
