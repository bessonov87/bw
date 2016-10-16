<?php

namespace common\models\ar;

use common\models\PostsRating as BasePostsRating;

class PostsRating extends BasePostsRating
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'ID статьи',
            'user_id' => 'ID пользователя',
            'score' => 'Голос',
        ];
    }

}
