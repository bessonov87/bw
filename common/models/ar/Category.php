<?php

namespace common\models\ar;

use common\models\Category as BaseCategory;

class Category extends BaseCategory
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent',
            'name' => 'Название',
            'url' => 'Ссылка',
            'icon' => 'Icon',
            'description' => 'Описание',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'post_sort' => 'Сортировка',
            'short_view' => 'Short View',
            'full_view' => 'Full View',
            'category_art' => 'Статья-категория',
            'header' => 'Header',
            'footer' => 'Footer',
            'add_method' => 'Дополнение',
            'postCount' => 'Статей',
        ];
    }

    /**
     * @return mixed
     */
    public function getPostCount(){
        return $this->hasMany(Post::className(), ['category_id' => 'id'])->count();
    }
}