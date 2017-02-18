<?php

use yii\db\Migration;

class m170218_085508_mod_user_add_profile_columns extends Migration
{
    public $tableName = '{{%user}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'sex', $this->string(1)->notNull()->defaultValue('f'));
        $this->addColumn($this->tableName, 'name', $this->string());
        $this->addColumn($this->tableName, 'surname', $this->string());
        $this->addColumn($this->tableName, 'birth_date', $this->date());
        $this->addColumn($this->tableName, 'country', $this->string());
        $this->addColumn($this->tableName, 'city', $this->string());
        $this->addColumn($this->tableName, 'avatar', $this->string());
        $this->addColumn($this->tableName, 'info', $this->text());
        $this->addColumn($this->tableName, 'signature', $this->string());
        $this->addColumn($this->tableName, 'last_visit', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->tableName, 'last_ip', $this->string());

        $this->createIndex('user_sex_idx', $this->tableName, 'sex');
        $this->createIndex('user_name_idx', $this->tableName, 'name');
        $this->createIndex('user_surname_idx', $this->tableName, 'surname');
        $this->createIndex('user_birth_date_idx', $this->tableName, 'birth_date');
        $this->createIndex('user_country_idx', $this->tableName, 'country');
        $this->createIndex('user_city_idx', $this->tableName, 'city');
        $this->createIndex('user_last_visit_idx', $this->tableName, 'last_visit');
        $this->createIndex('user_last_ip_idx', $this->tableName, 'last_ip');

        $profiles = \common\models\UserProfile::find();
        foreach ($profiles->each() as $profile){
            /** @var $profile \common\models\UserProfile */
            $sql = 'UPDATE "user" SET '.
              '"sex" = \''.$profile->sex.'\', 
              "name" = \''.$profile->name.'\', 
              "surname" = \''.$profile->surname.'\', 
              "birth_date" = \''.$profile->birth_date.'\', 
              "country" = \''.$profile->country.'\', 
              "city" = \''.$profile->city.'\', 
              "avatar" = \''.$profile->avatar.'\', 
              "info" = \''.$profile->info.'\', 
              "signature" = \''.$profile->signature.'\', 
              "last_visit" = '.$profile->last_visit.', 
              "last_ip" = \''.$profile->last_ip.'\' 
              WHERE id = '.$profile->user_id;

            $this->db->createCommand($sql)->execute();
        }
    }

    public function safeDown()
    {
        $this->dropIndex('user_last_ip_idx', $this->tableName);
        $this->dropIndex('user_last_visit_idx', $this->tableName);
        $this->dropIndex('user_city_idx', $this->tableName);
        $this->dropIndex('user_country_idx', $this->tableName);
        $this->dropIndex('user_birth_date_idx', $this->tableName);
        $this->dropIndex('user_surname_idx', $this->tableName);
        $this->dropIndex('user_name_idx', $this->tableName);
        $this->dropIndex('user_sex_idx', $this->tableName);

        $this->dropColumn($this->tableName, 'last_ip');
        $this->dropColumn($this->tableName, 'last_visit');
        $this->dropColumn($this->tableName, 'signature');
        $this->dropColumn($this->tableName, 'info');
        $this->dropColumn($this->tableName, 'avatar');
        $this->dropColumn($this->tableName, 'city');
        $this->dropColumn($this->tableName, 'country');
        $this->dropColumn($this->tableName, 'birth_date');
        $this->dropColumn($this->tableName, 'surname');
        $this->dropColumn($this->tableName, 'name');
        $this->dropColumn($this->tableName, 'sex');
    }
}
