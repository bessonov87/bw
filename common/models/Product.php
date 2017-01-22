<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $NDB_No
 * @property string $name
 * @property string $alt_name
 * @property string $icon
 * @property string $short_text
 * @property string $full_text
 * @property integer $category
 * @property string $descr
 * @property string $keywords
 * @property string $link
 * @property integer $info_saved
 * @property double $calories
 * @property double $protein
 * @property double $fat
 * @property double $carbohydrates
 * @property double $fiber
 * @property double $organic_acids
 * @property double $water
 * @property double $unsaturated_fatty_acids
 * @property double $saturated_fatty_acids
 * @property double $saccharides
 * @property double $starch
 * @property double $cholesterol
 * @property double $ash
 * @property double $alco
 * @property double $vit_pp
 * @property double $vit_beta_carotene
 * @property double $vit_a
 * @property double $vit_a_re
 * @property double $vit_b1
 * @property double $vit_b2
 * @property double $vit_b5
 * @property double $vit_b6
 * @property double $vit_b9
 * @property double $vit_b12
 * @property double $vit_c
 * @property double $vit_d
 * @property double $vit_e
 * @property double $vit_e_te
 * @property double $vit_h
 * @property double $vit_k
 * @property double $vit_pp_niacin
 * @property double $vit_choline
 * @property double $macro_ca
 * @property double $macro_mg
 * @property double $macro_na
 * @property double $macro_k
 * @property double $macro_p
 * @property double $macro_cl
 * @property double $macro_s
 * @property double $micro_fe
 * @property double $micro_zn
 * @property double $micro_j
 * @property double $micro_cu
 * @property double $micro_mn
 * @property double $micro_se
 * @property double $micro_cr
 * @property double $micro_f
 * @property double $micro_mo
 * @property double $micro_b
 * @property double $micro_v
 * @property double $micro_si
 * @property double $micro_co
 * @property double $micro_al
 * @property double $micro_ni
 * @property double $micro_sn
 * @property double $micro_rb
 * @property double $micro_ti
 * @property double $micro_sr
 * @property double $micro_zr
 * @property double $micro_li
 * @property integer $approve
 * @property integer $views
 * @property integer $comm_num
 *
 * @property ProductsCategory $category0
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NDB_No', 'category', 'info_saved', 'approve', 'views', 'comm_num'], 'integer'],
            [['short_text', 'full_text'], 'string'],
            [['calories', 'protein', 'fat', 'carbohydrates', 'fiber', 'organic_acids', 'water', 'unsaturated_fatty_acids', 'saturated_fatty_acids', 'saccharides', 'starch', 'cholesterol', 'ash', 'alco', 'vit_pp', 'vit_beta_carotene', 'vit_a', 'vit_a_re', 'vit_b1', 'vit_b2', 'vit_b5', 'vit_b6', 'vit_b9', 'vit_b12', 'vit_c', 'vit_d', 'vit_e', 'vit_e_te', 'vit_h', 'vit_k', 'vit_pp_niacin', 'vit_choline', 'macro_ca', 'macro_mg', 'macro_na', 'macro_k', 'macro_p', 'macro_cl', 'macro_s', 'micro_fe', 'micro_zn', 'micro_j', 'micro_cu', 'micro_mn', 'micro_se', 'micro_cr', 'micro_f', 'micro_mo', 'micro_b', 'micro_v', 'micro_si', 'micro_co', 'micro_al', 'micro_ni', 'micro_sn', 'micro_rb', 'micro_ti', 'micro_sr', 'micro_zr', 'micro_li'], 'number'],
            [['name', 'alt_name', 'icon', 'descr', 'keywords', 'link'], 'string', 'max' => 255],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsCategory::className(), 'targetAttribute' => ['category' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NDB_No' => 'Ndb  No',
            'name' => 'Name',
            'alt_name' => 'Alt Name',
            'icon' => 'Icon',
            'short_text' => 'Short Text',
            'full_text' => 'Full Text',
            'category' => 'Category',
            'descr' => 'Descr',
            'keywords' => 'Keywords',
            'link' => 'Link',
            'info_saved' => 'Info Saved',
            'calories' => 'Calories',
            'protein' => 'Protein',
            'fat' => 'Fat',
            'carbohydrates' => 'Carbohydrates',
            'fiber' => 'Fiber',
            'organic_acids' => 'Organic Acids',
            'water' => 'Water',
            'unsaturated_fatty_acids' => 'Unsaturated Fatty Acids',
            'saturated_fatty_acids' => 'Saturated Fatty Acids',
            'saccharides' => 'Saccharides',
            'starch' => 'Starch',
            'cholesterol' => 'Cholesterol',
            'ash' => 'Ash',
            'alco' => 'Alco',
            'vit_pp' => 'Vit Pp',
            'vit_beta_carotene' => 'Vit Beta Carotene',
            'vit_a' => 'Vit A',
            'vit_a_re' => 'Vit A Re',
            'vit_b1' => 'Vit B1',
            'vit_b2' => 'Vit B2',
            'vit_b5' => 'Vit B5',
            'vit_b6' => 'Vit B6',
            'vit_b9' => 'Vit B9',
            'vit_b12' => 'Vit B12',
            'vit_c' => 'Vit C',
            'vit_d' => 'Vit D',
            'vit_e' => 'Vit E',
            'vit_e_te' => 'Vit E Te',
            'vit_h' => 'Vit H',
            'vit_k' => 'Vit K',
            'vit_pp_niacin' => 'Vit Pp Niacin',
            'vit_choline' => 'Vit Choline',
            'macro_ca' => 'Macro Ca',
            'macro_mg' => 'Macro Mg',
            'macro_na' => 'Macro Na',
            'macro_k' => 'Macro K',
            'macro_p' => 'Macro P',
            'macro_cl' => 'Macro Cl',
            'macro_s' => 'Macro S',
            'micro_fe' => 'Micro Fe',
            'micro_zn' => 'Micro Zn',
            'micro_j' => 'Micro J',
            'micro_cu' => 'Micro Cu',
            'micro_mn' => 'Micro Mn',
            'micro_se' => 'Micro Se',
            'micro_cr' => 'Micro Cr',
            'micro_f' => 'Micro F',
            'micro_mo' => 'Micro Mo',
            'micro_b' => 'Micro B',
            'micro_v' => 'Micro V',
            'micro_si' => 'Micro Si',
            'micro_co' => 'Micro Co',
            'micro_al' => 'Micro Al',
            'micro_ni' => 'Micro Ni',
            'micro_sn' => 'Micro Sn',
            'micro_rb' => 'Micro Rb',
            'micro_ti' => 'Micro Ti',
            'micro_sr' => 'Micro Sr',
            'micro_zr' => 'Micro Zr',
            'micro_li' => 'Micro Li',
            'approve' => 'Approve',
            'views' => 'Views',
            'comm_num' => 'Comm Num',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(ProductsCategory::className(), ['id' => 'category']);
    }
}
