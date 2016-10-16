<?php

use yii\db\Migration;

class m161015_191450_add_images extends Migration
{
    public $tableName = '{{%images}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'image_name' => $this->string()->notNull(),
            'folder' => $this->string(),
            'post_id' => $this->bigInteger()->notNull()->defaultValue(0),
            'r_id' => $this->string(6),
            'user_id' => $this->bigInteger()->notNull(),
            'date' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('images_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('images_r_id_idx', $this->tableName, 'r_id');
        $this->createIndex('images_image_name_idx', $this->tableName, 'image_name');
        $this->createIndex('images_date_idx', $this->tableName, 'date');
    }

    public function safeDown()
    {
        $this->dropIndex('images_date_idx', $this->tableName);
        $this->dropIndex('images_image_name_idx', $this->tableName);
        $this->dropIndex('images_r_id_idx', $this->tableName);

        $this->dropForeignKey('images_user_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
