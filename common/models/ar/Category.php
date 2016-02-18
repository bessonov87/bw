<?php

namespace common\models\ar;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property string $description
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_keywords
 * @property string $post_sort
 * @property string $short_view
 * @property string $full_view
 * @property integer $category_art
 * @property string $header
 * @property string $footer
 * @property string $add_method
 *
 * @property string $postCount
 */
class Category extends ActiveRecord {

    public static function tableName(){
        return '{{%category}}';
    }

    /**
     *
     *
     * @return mixed
     */
    public function getPostCount(){
        return $this->hasMany(Post::className(), ['category_id' => 'id'])->count();
    }

    /*public function getPosts(){
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }*/

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

}