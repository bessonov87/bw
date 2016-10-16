<?php

namespace common\models\ar;

use common\models\Images as BaseImages;

class Images extends BaseImages
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_name' => 'Images',
            'folder' => 'Папка',
            'post_id' => 'Post ID',
            'r_id' => 'R ID',
            'user_id' => 'User ID',
            'date' => 'Date',
        ];
    }
}
