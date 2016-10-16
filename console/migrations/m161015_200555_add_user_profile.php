<?php

use yii\db\Migration;

class m161015_200555_add_user_profile extends Migration
{
    public $tableName = '{{%user_profile}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'user_id' => $this->bigPrimaryKey(),
            'sex' => $this->string(1)->notNull()->defaultValue('f'),
            'name' => $this->string(),
            'surname' => $this->string(),
            'birth_date' => $this->date(),
            'country' => $this->string(),
            'city' => $this->string(),
            'avatar' => $this->string(),
            'info' => $this->text(),
            'signature' => $this->string(),
            'last_visit' => $this->integer()->notNull()->defaultValue(0),
            'last_ip' => $this->string()
        ]);

        $this->addForeignKey('user_profile_user_id_fk', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('user_profile_sex_idx', $this->tableName, 'sex');
        $this->createIndex('user_profile_name_idx', $this->tableName, 'name');
        $this->createIndex('user_profile_birth_date_idx', $this->tableName, 'birth_date');
        $this->createIndex('user_profile_country_idx', $this->tableName, 'country');
        $this->createIndex('user_profile_last_visit_idx', $this->tableName, 'last_visit');
    }

    public function safeDown()
    {
        $this->dropIndex('user_profile_last_visit_idx', $this->tableName);
        $this->dropIndex('user_profile_country_idx', $this->tableName);
        $this->dropIndex('user_profile_birth_date_idx', $this->tableName);
        $this->dropIndex('user_profile_name_idx', $this->tableName);
        $this->dropIndex('user_profile_sex_idx', $this->tableName);

        $this->dropForeignKey('user_profile_user_id_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
