<?php

use yii\db\Migration;

class m170121_212715_add_product extends Migration
{
    public $tableName = '{{%product}}';

    protected $fields = [
        "id" => 'bigPrimaryKey',
        "NDB_No" => 'integer',
        "name" => 'string',
        "alt_name" => 'string',
        "icon" => 'string',
        "short_text" => 'text',
        "full_text" => 'text',
        "category" => 'bigInteger',
        "descr" => 'string',
        "keywords" => 'string',
        "link" => 'string',
        "info_saved" => 'smallInteger',
        "calories" => 'float',
        "protein" => 'float',
        "fat" => 'float',
        "carbohydrates" => 'float',
        "fiber" => 'float',
        "organic_acids" => 'float',
        "water" => 'float',
        "unsaturated_fatty_acids" => 'float',
        "saturated_fatty_acids" => 'float',
        "saccharides" => 'float',
        "starch" => 'float',
        "cholesterol" => 'float',
        "ash" => 'float',
        "alco" => 'float',
        "vit_pp" => 'float',
        "vit_beta_carotene" => 'float',
        "vit_a" => 'float',
        "vit_a_re" => 'float',
        "vit_b1" => 'float',
        "vit_b2" => 'float',
        "vit_b5" => 'float',
        "vit_b6" => 'float',
        "vit_b9" => 'float',
        "vit_b12" => 'float',
        "vit_c" => 'float',
        "vit_d" => 'float',
        "vit_e" => 'float',
        "vit_e_te" => 'float',
        "vit_h" => 'float',
        "vit_k" => 'float',
        "vit_pp_niacin" => 'float',
        "vit_choline" => 'float',
        "macro_ca" => 'float',
        "macro_mg" => 'float',
        "macro_na" => 'float',
        "macro_k" => 'float',
        "macro_p" => 'float',
        "macro_cl" => 'float',
        "macro_s" => 'float',
        "micro_fe" => 'float',
        "micro_zn" => 'float',
        "micro_j" => 'float',
        "micro_cu" => 'float',
        "micro_mn" => 'float',
        "micro_se" => 'float',
        "micro_cr" => 'float',
        "micro_f" => 'float',
        "micro_mo" => 'float',
        "micro_b" => 'float',
        "micro_v" => 'float',
        "micro_si" => 'float',
        "micro_co" => 'float',
        "micro_al" => 'float',
        "micro_ni" => 'float',
        "micro_sn" => 'float',
        "micro_rb" => 'float',
        "micro_ti" => 'float',
        "micro_sr" => 'float',
        "micro_zr" => 'float',
        "micro_li" => 'float',
        "approve" => 'smallInteger',
        "views" => 'integer',
        "comm_num" => 'integer',
    ];

    protected $noIndexFields = ['id', 'category', 'icon', 'short_text', 'full_text'];

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $fields = [];
        foreach ($this->fields as $field => $type){
            $fields[$field] = $this->$type();
        }

        $this->createTable($this->tableName, $fields);

        $this->addForeignKey('product_category_fk', $this->tableName, 'category', '{{%products_category}}', 'id', 'CASCADE', 'CASCADE');

        foreach ($fields as $field => $type){
            if(in_array($field, $this->noIndexFields)){
                continue;
            }
            $this->createIndex('product_'.$field.'_idx', $this->tableName, $field);
        }
    }

    public function safeDown()
    {
        foreach ($this->fields as $field => $type){
            if(in_array($field, $this->noIndexFields)){
                continue;
            }
            $this->dropIndex('product_'.$field.'_idx', $this->tableName);
        }

        $this->dropForeignKey('product_category_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
