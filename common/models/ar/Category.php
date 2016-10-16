<?php

namespace common\models\ar;

use common\models\Category as BaseCategory;

class Category extends BaseCategory
{
    /**
     * @return mixed
     */
    public function getPostCount(){
        return $this->hasMany(Post::className(), ['category_id' => 'id'])->count();
    }
}