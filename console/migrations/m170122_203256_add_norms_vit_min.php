<?php

use yii\db\Migration;

class m170122_203256_add_norms_vit_min extends Migration
{
    public $tableName = '{{%norms_vit_min}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull(),
            'alt_name' => $this->string()->notNull(),
            'unit' => $this->string()->notNull(),
            'value' => $this->double()->notNull(),
            'sex' => $this->string()->notNull(),
        ]);

        $this->createIndex('norms_vit_min_alt_name_idx', $this->tableName, 'alt_name');
        $this->createIndex('norms_vit_min_unit_idx', $this->tableName, 'unit');
        $this->createIndex('norms_vit_min_sex_idx', $this->tableName, 'sex');

        $norms = [
            ['id' => 1, 'name' => 'Калий', 'alt_name' => 'macro_k',	'unit' => 'мг', 'value' => 2500, 'sex' => 'a'],
            ['id' => 2, 'name' => 'Кальций', 'alt_name' => 'macro_ca', 'unit' => 'мг', 'value' => 1000, 'sex' => 'a'],
            ['id' => 3, 'name' => 'Магний', 'alt_name' => 'macro_mg', 'unit' => 'мг', 'value' => 400, 'sex' => 'a'],
            ['id' => 4, 'name' => 'Натрий', 'alt_name' => 'macro_na', 'unit' => 'мг', 'value' => 1300, 'sex' => 'a'],
            ['id' => 5, 'name' => 'Сера', 'alt_name' => 'macro_s', 'unit' => 'мг', 'value' => 1000, 'sex' => 'a'],
            ['id' => 6, 'name' => 'Фосфор', 'alt_name' => 'macro_p', 'unit' => 'мг', 'value' => 800, 'sex' => 'a'],
            ['id' => 7, 'name' => 'Хлор', 'alt_name' => 'macro_cl', 'unit' => 'мг', 'value' => 2300, 'sex' => 'a'],
            ['id' => 8, 'name' => 'Железо', 'alt_name' => 'micro_fe', 'unit' => 'мг', 'value' => 10, 'sex' => 'm'],
            ['id' => 9, 'name' => 'Железо', 'alt_name' => 'micro_fe', 'unit' => 'мг', 'value' => 18, 'sex' => 'w'],
            ['id' => 10, 'name' => 'Цинк', 'alt_name' => 'micro_zn', 'unit' => 'мг', 'value' => 12, 'sex' => 'a'],
            ['id' => 11, 'name' => 'Йод', 'alt_name' => 'micro_j', 'unit' => 'мкг', 'value' => 150, 'sex' => 'a'],
            ['id' => 12, 'name' => 'Медь', 'alt_name' => 'micro_cu', 'unit' => 'мг', 'value' => 1, 'sex' => 'a'],
            ['id' => 13, 'name' => 'Марганец', 'alt_name' => 'micro_mn', 'unit' => 'мг', 'value' => 2, 'sex' => 'a'],
            ['id' => 14, 'name' => 'Селен', 'alt_name' => 'micro_se', 'unit' => 'мкг', 'value' => 55, 'sex' => 'w'],
            ['id' => 15, 'name' => 'Селен', 'alt_name' => 'micro_se', 'unit' => 'мкг', 'value' => 70, 'sex' => 'm'],
            ['id' => 16, 'name' => 'Хром', 'alt_name' => 'micro_cr', 'unit' => 'мкг', 'value' => 50, 'sex' => 'a'],
            ['id' => 17, 'name' => 'Молибден', 'alt_name' => 'micro_mo', 'unit' => 'мкг', 'value' => 70, 'sex' => 'a'],
            ['id' => 18, 'name' => 'Фтор', 'alt_name' => 'micro_f', 'unit' => 'мкг', 'value' => 4000, 'sex' => 'a'],
            ['id' => 19, 'name' => 'Кобальт', 'alt_name' => 'micro_co', 'unit' => 'мкг', 'value' => 10, 'sex' => 'a'],
            ['id' => 20, 'name' => 'Кремний', 'alt_name' => 'micro_si', 'unit' => 'мг', 'value' => 30, 'sex' => 'a'],
            ['id' => 21, 'name' => 'Бор', 'alt_name' => 'micro_b', 'unit' => 'мг', 'value' => 2, 'sex' => 'a'],
            ['id' => 22, 'name' => 'Ванадий', 'alt_name' => 'micro_v', 'unit' => 'мкг', 'value' => 40, 'sex' => 'a'],
            ['id' => 23, 'name' => 'Витамин C', 'alt_name' => 'vit_c', 'unit' => 'мг', 'value' => 90, 'sex' => 'a'],
            ['id' => 24, 'name' => 'Витамин B1 (тиамин)', 'alt_name' => 'vit_b1', 'unit' => 'мг', 'value' => 1.5, 'sex' => 'a'],
            ['id' => 25, 'name' => 'Витамин B2 (рибофлавин)', 'alt_name' => 'vit_b2', 'unit' => 'мг', 'value' => 1.8, 'sex' => 'a'],
            ['id' => 26, 'name' => 'Витамин B5 (пантотеновая кислота)', 'alt_name' => 'vit_b5',	 'unit' => 'мг', 'value' => 5, 'sex' => 'a'],
            ['id' => 27, 'name' => 'Витамин B6 (пиридоксин)', 'alt_name' => 'vit_b6', 'unit' => 'мг', 'value' => 2, 'sex' => 'a'],
            ['id' => 28, 'name' => 'Витамин PP (ниацин)', 'alt_name' => 'vit_pp_niacin', 'unit' => 'мг', 'value' => 20, 'sex' => 'a'],
            ['id' => 29, 'name' => 'Витамин B12 (цианокобаламин)', 'alt_name' => 'vit_b12', 'unit' => 'мкг', 'value' => 3, 'sex' => 'a'],
            ['id' => 30, 'name' => 'Витамин B9 (фолиевая кислота)', 'alt_name' => 'vit_b9', 'unit' => 'мкг', 'value' => 400, 'sex' => 'a'],
            ['id' => 31, 'name' => 'Витамин H (биотин)', 'alt_name' => 'vit_h', 'unit' => 'мкг', 'value' => 50, 'sex' => 'a'],
            ['id' => 32, 'name' => 'Витамин A (РЭ)', 'alt_name' => 'vit_a_re', 'unit' => 'мкг',	'value' => 900,	'sex' => 'a'],
            ['id' => 33, 'name' => 'Бета-каротин', 'alt_name' => 'vit_beta_carotene', 'unit' => 'мг', 'value' => 5, 'sex' => 'a'],
            ['id' => 34, 'name' => 'Витамин E (ТЭ)', 'alt_name' => 'vit_e_te', 'unit' => 'мг', 'value' => 15, 'sex' => 'a'],
            ['id' => 35, 'name' => 'Витамин D', 'alt_name' => 'vit_d', 'unit' => 'мкг',	'value' => 10, 'sex' => 'a'],
            ['id' => 36, 'name' => 'Витамин K (филлохинон)', 'alt_name' => 'vit_k', 'unit' => 'мкг', 'value' => 120, 'sex' => 'a'],
            ['id' => 37, 'name' => 'Холин', 'alt_name' => 'vit_choline',	 'unit' => 'мг', 'value' => 500, 'sex' => 'a'],
        ];

        foreach ($norms as $norm){
            $fields = [];
            $values = [];
            foreach ($norm as $key => $value){
                $fields[] = $key;
                $values[] = ($key == 'id' || $key == 'value') ? $value : "'$value'";
            }
            $sql = 'INSERT INTO '.$this->tableName.' ('.implode(',', $fields).') VALUES('.implode(',', $values).')';
            Yii::$app->db->createCommand($sql)->execute();
        }
    }

    public function safeDown()
    {
        $this->dropIndex('norms_vit_min_sex_idx', $this->tableName);
        $this->dropIndex('norms_vit_min_unit_idx', $this->tableName);
        $this->dropIndex('norms_vit_min_alt_name_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
