<?php

use yii\db\Migration;

class m161015_200137_add_usergroups extends Migration
{
    public $tableName = '{{%usergroups}}';

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->bigPrimaryKey(),
            'group_name' => $this->string()->notNull(),
            'captcha' => $this->smallInteger()->notNull()->defaultValue(0),
            'icon' => $this->string()
        ]);

        $this->insert($this->tableName, ['group_name' => 'Администраторы', 'captcha' => 0]);
        $this->insert($this->tableName, ['group_name' => 'Главные редакторы', 'captcha' => 0]);
        $this->insert($this->tableName, ['group_name' => 'Журналисты', 'captcha' => 0]);
        $this->insert($this->tableName, ['group_name' => 'Посетители', 'captcha' => 0]);
        $this->insert($this->tableName, ['group_name' => 'Гости', 'captcha' => 0]);
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
