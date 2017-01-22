<?php

use yii\db\Migration;

class m170122_212533_add_norms_fat_prot extends Migration
{
    public $tableName = '{{%norms_fat_prot}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'sex' => $this->string()->notNull(),
            'groupa' => $this->smallInteger(),
            'age' => $this->string()->notNull(),
            'energy' => $this->integer(),
            'protein' => $this->integer(),
            'fat' => $this->integer(),
            'carbohydrate' => $this->integer(),
        ]);

        $norms = [
            ['id' => 1, 'sex' => 'm', 'groupa' => 1, 'age' => '18-29', 'energy' => 2450, 'protein' => 72, 'fat' => 81, 'carbohydrate' => 358],
            ['id' => 2, 'sex' => 'm', 'groupa' => 1, 'age' => '30-39', 'energy' => 2300, 'protein' => 68, 'fat' => 77, 'carbohydrate' => 335],
            ['id' => 3, 'sex' => 'm', 'groupa' => 1, 'age' => '40-59', 'energy' => 2100, 'protein' => 65, 'fat' => 70, 'carbohydrate' => 303],
            ['id' => 4, 'sex' => 'm', 'groupa' => 0, 'age' => '>60', 'energy' => 2300, 'protein' => 68, 'fat' => 77, 'carbohydrate' => 335],
            ['id' => 5, 'sex' => 'm', 'groupa' => 2, 'age' => '18-29', 'energy' => 2800, 'protein' => 80, 'fat' => 93, 'carbohydrate' => 411],
            ['id' => 6, 'sex' => 'm', 'groupa' => 2, 'age' => '30-39', 'energy' => 2650, 'protein' => 77, 'fat' => 88, 'carbohydrate' => 387],
            ['id' => 7, 'sex' => 'm', 'groupa' => 2, 'age' => '40-59', 'energy' => 2500, 'protein' => 72, 'fat' => 83, 'carbohydrate' => 366],
            ['id' => 8, 'sex' => 'm', 'groupa' => 3, 'age' => '18-29', 'energy' => 3300, 'protein' => 94, 'fat' => 110, 'carbohydrate' => 484],
            ['id' => 9, 'sex' => 'm', 'groupa' => 3, 'age' => '30-39', 'energy' => 3150, 'protein' => 89, 'fat' => 105, 'carbohydrate' => 462],
            ['id' => 10, 'sex' => 'm', 'groupa' => 3, 'age' => '40-59', 'energy' => 2950, 'protein' => 84, 'fat' => 98, 'carbohydrate' => 432],
            ['id' => 11, 'sex' => 'm', 'groupa' => 4, 'age' => '18-29', 'energy' => 3850, 'protein' => 108, 'fat' => 128, 'carbohydrate' => 566],
            ['id' => 12, 'sex' => 'm', 'groupa' => 4, 'age' => '30-39', 'energy' => 3600, 'protein' => 102, 'fat' => 120, 'carbohydrate' => 528],
            ['id' => 13, 'sex' => 'm', 'groupa' => 4, 'age' => '40-59', 'energy' => 3400, 'protein' => 96, 'fat' => 113, 'carbohydrate' => 499],
            ['id' => 14, 'sex' => 'm', 'groupa' => 5, 'age' => '18-29', 'energy' => 4200, 'protein' => 117, 'fat' => 154, 'carbohydrate' => 586],
            ['id' => 15, 'sex' => 'm', 'groupa' => 5, 'age' => '30-39', 'energy' => 3950, 'protein' => 111, 'fat' => 144, 'carbohydrate' => 550],
            ['id' => 16, 'sex' => 'm', 'groupa' => 5, 'age' => '40-59', 'energy' => 3750, 'protein' => 104, 'fat' => 137, 'carbohydrate' => 524],
            ['id' => 17, 'sex' => 'w', 'groupa' => 1, 'age' => '18-29', 'energy' => 2000, 'protein' => 61, 'fat' => 67, 'carbohydrate' => 289],
            ['id' => 18, 'sex' => 'w', 'groupa' => 1, 'age' => '30-39', 'energy' => 1900, 'protein' => 59, 'fat' => 63, 'carbohydrate' => 274],
            ['id' => 19, 'sex' => 'w', 'groupa' => 1, 'age' => '40-59', 'energy' => 1800, 'protein' => 58, 'fat' => 60, 'carbohydrate' => 257],
            ['id' => 20, 'sex' => 'w', 'groupa' => 0, 'age' => '>60', 'energy' => 1975, 'protein' => 61, 'fat' => 66, 'carbohydrate' => 284],
            ['id' => 21, 'sex' => 'w', 'groupa' => 2, 'age' => '18-29', 'energy' => 2200, 'protein' => 66, 'fat' => 73, 'carbohydrate' => 318],
            ['id' => 22, 'sex' => 'w', 'groupa' => 2, 'age' => '30-39', 'energy' => 2150, 'protein' => 65, 'fat' => 72, 'carbohydrate' => 311],
            ['id' => 23, 'sex' => 'w', 'groupa' => 2, 'age' => '40-59', 'energy' => 2100, 'protein' => 63, 'fat' => 70, 'carbohydrate' => 305],
            ['id' => 24, 'sex' => 'w', 'groupa' => 3, 'age' => '18-29', 'energy' => 2600, 'protein' => 76, 'fat' => 87, 'carbohydrate' => 378],
            ['id' => 25, 'sex' => 'w', 'groupa' => 3, 'age' => '30-39', 'energy' => 2550, 'protein' => 74, 'fat' => 85, 'carbohydrate' => 372],
            ['id' => 26, 'sex' => 'w', 'groupa' => 3, 'age' => '40-59', 'energy' => 2500, 'protein' => 72, 'fat' => 83, 'carbohydrate' => 366],
            ['id' => 27, 'sex' => 'w', 'groupa' => 4, 'age' => '18-29', 'energy' => 3050, 'protein' => 87, 'fat' => 102, 'carbohydrate' => 462],
            ['id' => 28, 'sex' => 'w', 'groupa' => 4, 'age' => '30-39', 'energy' => 2950, 'protein' => 84, 'fat' => 98, 'carbohydrate' => 432],
            ['id' => 29, 'sex' => 'w', 'groupa' => 4, 'age' => '40-59', 'energy' => 2850, 'protein' => 82, 'fat' => 95, 'carbohydrate' => 417],
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
        $this->dropTable($this->tableName);
    }
}
