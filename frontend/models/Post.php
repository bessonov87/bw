<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use common\models\Comment;

class Post extends ActiveRecord
{
    const APPROVED = 1;

    // Первый способ связи
    /*public function getCategories(){
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('post_category', ['post_id' => 'id']);
    }*/

    // Второй способ связи
    public function getPostCategories(){
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }

    public function getCategories(){
        $categories = $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->via('postCategories')->asArray();
        return $categories;
    }

    public function getSimilarPosts(){
        $similarPosts = Post::find()
            ->where("MATCH(short, full, title, meta_title) AGAINST('$this->title')")
            ->where(['approve' => static::APPROVED])
            ->limit(5)
            ->all();
        return $similarPosts;
    }

    public function getComments(){
        $comments = $this->hasMany(Comment::className(), ['post_id' => 'id']);
        return $comments;
    }

    public static function tableName(){
        return 'post';
    }
}