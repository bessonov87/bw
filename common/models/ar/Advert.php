<?php

namespace common\models\ar;

use common\models\Advert as BaseAdvert;

class Advert extends BaseAdvert
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'block_number' => 'Номер блока',
            'code' => 'Код вставки',
            'location' => 'Место',
            'replacement_tag' => 'Тэг замены',
            'category' => 'Категория',
            'approve' => 'Разрешен?',
            'on_request' => 'On Request',
        ];
    }
}
