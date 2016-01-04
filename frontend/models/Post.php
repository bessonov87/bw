<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use common\models\Comment;
use yii\helpers\Url;

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
            ->andWhere(['approve' => static::APPROVED])
            ->limit(5)
            ->all();
        return $similarPosts;
    }

    /**
     * Получение комментариев для статьи
     *
     * У комментариев имеется связь getUser для получения информации о пользователе, оставившем комментарий.
     * Для минимизации кол-ва запросов к базе используется "жадная загрузка" посредством метода with() со
     * связью user.
     *
     * @return $this
     */
    public function getComments(){
        $comments = $this->hasMany(Comment::className(), ['post_id' => 'id'])->with('user')->asArray();
        return $comments;
    }

    public function getLink(){
        $cat = GlobalHelper::getCategoryUrlById($this->postCategories[0]->category_id);
        return Url::to(['post/full', 'cat' => $cat, 'id' => $this->id, 'alt' => $this->url]);
    }

    public static function tableName(){
        return 'post';
    }
}