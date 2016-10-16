<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
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
 * @property integer $post_num
 * @property string $short_view
 * @property string $full_view
 * @property integer $category_art
 * @property string $header
 * @property string $footer
 * @property string $add_method
 *
 * @property Post[] $posts
 * @property PostCategory[] $postCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'post_num', 'category_art'], 'integer'],
            [['name', 'url'], 'required'],
            [['description', 'header', 'footer'], 'string'],
            [['name', 'url', 'icon', 'meta_title', 'meta_descr', 'meta_keywords', 'post_sort', 'short_view', 'full_view', 'add_method'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'url' => 'Url',
            'icon' => 'Icon',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Descr',
            'meta_keywords' => 'Meta Keywords',
            'post_sort' => 'Post Sort',
            'post_num' => 'Post Num',
            'short_view' => 'Short View',
            'full_view' => 'Full View',
            'category_art' => 'Category Art',
            'header' => 'Header',
            'footer' => 'Footer',
            'add_method' => 'Add Method',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['category_id' => 'id']);
    }
}
