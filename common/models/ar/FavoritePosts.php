<?php

namespace common\models\ar;

use common\models\FavoritePosts as BaseFavoritePosts;

class FavoritePosts extends BaseFavoritePosts
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'post_id' => 'ID статьи',
            'link' => 'Ссылка',
            'title' => 'Заголовок',
            'date' => 'Дата добавления',
            'external' => 'Внешняя?',
        ];
    }
}
