<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $parent_id
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
 * @property string $category_art
 * @property string $header
 * @property string $footer
 * @property string $add_method
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['parent_id', 'post_num', 'category_art'], 'integer'],
            [['description', 'header', 'footer'], 'string'],
            [['name', 'icon', 'meta_title', 'meta_descr', 'meta_keywords', 'post_sort'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 50],
            [['short_view', 'full_view'], 'string', 'max' => 40],
            [['add_method'], 'string', 'max' => 25]
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
}
