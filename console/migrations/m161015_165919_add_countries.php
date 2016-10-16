<?php

use yii\db\Migration;

class m161015_165919_add_countries extends Migration
{
    public $tableName = '{{%countries}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'title_ru' => $this->string(60),
            'title_ua' => $this->string(60),
            'title_be' => $this->string(60),
            'title_en' => $this->string(60),
            'title_es' => $this->string(60),
            'title_pt' => $this->string(60),
            'title_de' => $this->string(60),
            'title_fr' => $this->string(60),
            'title_it' => $this->string(60),
            'title_pl' => $this->string(60),
            'title_ja' => $this->string(60),
            'title_lt' => $this->string(60),
            'title_lv' => $this->string(60),
            'title_cz' => $this->string(60)
        ]);

        $this->createIndex('countries_title_ru_idx', $this->tableName, 'title_ru');
        $this->createIndex('countries_title_en_idx', $this->tableName, 'title_en');
    }

    public function safeDown()
    {
        $this->dropIndex('countries_title_en_idx', $this->tableName);
        $this->dropIndex('countries_title_ru_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
