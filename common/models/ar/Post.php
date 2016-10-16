<?php

namespace common\models\ar;

use common\models\Post as BasePost;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\components\helpers\GlobalHelper;

class Post extends BasePost
{
    const APPROVED = 1;
    const NOT_APPROVED = 0;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'date' => 'Date',
            'category_id' => 'Категория',
            'short' => 'Short',
            'full' => 'Full',
            'title' => 'Title',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Descr',
            'meta_keywords' => 'Meta Keywords',
            'url' => 'Url',
            'related' => 'Похожие',
            'views' => 'Views',
            'edit_date' => 'Edit Date',
            'edit_user' => 'Edit User',
            'edit_reason' => 'Edit Reason',
            'allow_comm' => 'Allow Comm',
            'allow_main' => 'Allow Main',
            'allow_catlink' => 'Allow Catlink',
            'allow_similar' => 'Allow Similar',
            'allow_rate' => 'Allow Rate',
            'approve' => 'Approve',
            'fixed' => 'Fixed',
            'category_art' => 'CArt',
            'inm' => 'Inm',
            'not_in_related' => 'Not In Related',
            'commentsCount' => 'Комменты',
            'skin' => 'SkinCare Id',
        ];
    }

    /**
     * Возвращает название статуса статьи по значению из базы
     *
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->approve);
    }

    /**
     * Возвращает массив со статусами статей
     *
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::APPROVED => 'Разрешена',
            self::NOT_APPROVED => 'Запрещена',
        ];
    }

    /**
     * Возвращает название категории, в которой размещена статья
     *
     * @return mixed
     */
    public function getCategoryName(){
        return $this->category->name;
    }

    /**
     * Возвращает набор похожих статей для данной статьи, если они разрешены
     *
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public function getSimilarPosts(){
        // Если для данной статьи похожие запрещены, возвращаем null
        if(!$this->allow_similar)
            return null;

        // TODO NORMAL SIMILAR POSTS SEARCH
        $text = mb_ereg_replace('/[^a-zA-Zа-яА-Я-]/siU', '', $this->title);
        if(mb_strlen($text) > 50){
            $text = mb_substr($text, 0, 50);
        }
        $words = explode(" ", $text);
        $wordsList = [];
        if(is_array($words)) {
            if(count($words) > 1) {
                foreach ($words as $word) {
                    if (mb_strlen($word) > 3) {
                        $wordsList[] = $word;
                    }
                }
            } else {
                $wordsList = $words;
            }
        } else {
            $wordsList[] = $words;
        }

        $query = Post::find()->andWhere(['approve' => static::APPROVED])
            ->andWhere( 'id != '.$this->id )
            ->andWhere(['not_in_related' => 0])
            ->andWhere(['category_art' => 0]);
        $likeCondition = '';
        $likeCondition2 = '';
        foreach ($wordsList as $word){
            $likeCondition .= "OR \"title\" ILIKE '%$word%' ";
            $likeCondition2 .= $likeCondition . "OR \"full\" ILIKE '%$word%' ";
        }
        if($likeCondition){
            $likeCondition = mb_substr($likeCondition, 3);
            $query->andWhere($likeCondition);
        }
        if($likeCondition2){
            $likeCondition2 = mb_substr($likeCondition2, 3);
            $query2 = clone $query;
            $query2->andWhere($likeCondition2);
        }

        $similarPosts = $query
            ->limit(5)
            ->all();

        if($likeCondition2 && (!$similarPosts || count($similarPosts) < 4)){
            $similarPosts = $query2
                ->limit(5)
                ->all();
        }

        return $similarPosts;
    }

    /**
     * Сеттер, позволяющий обойти исключение (Setting Read-only property) при ручном заполнении похожих статей
     *
     * @param array $val Массив объектов класса Post, заданных в качестве похожих для данной статьи
     */
    public function setSimilarPosts($val){
        $this->similarPosts = $val;
    }

    /**
     * Получение комментариев для статьи
     *
     * У комментариев имеется связь getUser для получения информации о пользователе, оставившем комментарий.
     * Для минимизации кол-ва запросов к базе используется "жадная загрузка" посредством метода with() со
     * связью user.
     *
     * @return ActiveQuery
     */
    public function getComments(){
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->with('user')->asArray();
    }

    /**
     * Возвращает количество комментариев для данной статьи
     * @return int
     */
    public function getCommentsCount(){
        return count($this->comments);
    }

    /**
     * Возвращает рейтинг статьи (сумму выставленных плюсов и минусов)
     * @return integer
     */
    public function getPostsRating(){
        $rates = $this->hasMany(PostsRating::className(), ['post_id' => 'id'])->sum('score');
        return $rates;
    }

    /**
     * Возвращает относительную ссылку на статью
     * @return string
     */
    public function getLink(){
        $cat = GlobalHelper::getCategoryUrlById($this->category_id);
        return Url::to(['post/full', 'cat' => $cat, 'id' => $this->id, 'alt' => $this->url]);
    }

    /**
     * Ссылка на статью (для бэкэнда)
     * @return string
     */
    public function getFrontendLink(){
        $cat = GlobalHelper::getCategoryUrlById($this->category_id);
        return substr(\Yii::$app->params['frontendBaseUrl'], 0, -1).\Yii::$app->urlManagerFrontend->createUrl(['post/full', 'cat' => $cat, 'id' => $this->id, 'alt' => $this->url]);
    }

    /**
     * Возвращает абсолютную ссылку на статью
     * @return string
     */
    public function getAbsoluteLink() {
        return \Yii::$app->params['frontendBaseUrl'].substr($this->link, 1);
    }

}