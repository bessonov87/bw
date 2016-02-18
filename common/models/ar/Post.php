<?php

namespace common\models\ar;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ar\Comment;
use common\models\ar\Category;
use common\components\helpers\GlobalHelper;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $author_id
 * @property string $date
 * @property integer $category_id
 * @property string $short
 * @property string $full
 * @property string $title
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_keywords
 * @property string $url
 * @property string $views
 * @property string $edit_date
 * @property string $edit_user
 * @property string $edit_reason
 * @property integer $allow_comm
 * @property integer $allow_main
 * @property integer $allow_catlink
 * @property integer $allow_similar
 * @property integer $allow_rate
 * @property integer $approve
 * @property integer $fixed
 * @property integer $category_art
 * @property integer $inm
 * @property integer $not_in_related
 *
 * @property Comment[] $comments
 * @property FavoritePosts[] $favoritePosts
 * @property User $author
 * @property PostsRating[] $postsRatings
 */
class Post extends ActiveRecord
{
    const APPROVED = 1;
    const NOT_APPROVED = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'date', 'category_id', 'short', 'full', 'title', 'url'], 'required'],
            [['author_id', 'category_id', 'views', 'edit_user', 'allow_comm', 'allow_main', 'allow_catlink', 'allow_similar', 'allow_rate', 'approve', 'fixed', 'category_art', 'inm', 'not_in_related'], 'integer'],
            [['edit_date', 'commentsCount'], 'safe'],
            [['short', 'full'], 'string'],
            [['title', 'meta_title', 'meta_descr', 'meta_keywords', 'edit_reason'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 100]
        ];
    }

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
        ];
    }

    // Первый способ связи
    /*public function getCategories(){
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('post_category', ['post_id' => 'id']);
    }*/

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

    /*// Второй способ связи
    public function getPostCategories(){
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }

    // Одна категория для статьи
    public function getPostCategory(){
        return $this->hasOne(PostCategory::className(), ['post_id' => 'id']);
    }

    public function getCategory(){
        $category = $this->hasOne(Category::className(), ['id' => 'category_id'])
            ->via('postCategory');
        return $category;
    }

    public function getCategories(){
        $categories = $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->via('postCategories')->asArray();
        return $categories;
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
        $similarPosts = Post::find()
            ->where("MATCH(short, full, title, meta_title) AGAINST('$this->title')")
            ->andWhere(['approve' => static::APPROVED])
            ->andWhere( 'id != '.$this->id )
            ->andWhere(['not_in_related' => 0])
            ->andWhere(['category_art' => 0])
            ->limit(5)
            ->all();
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
     * @return $this
     */
    public function getComments(){
        $comments = $this->hasMany(Comment::className(), ['post_id' => 'id'])->with('user')->asArray();
        return $comments;
    }

    public function getCommentsCount(){
        return count($this->comments);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritePosts()
    {
        return $this->hasMany(FavoritePosts::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getPostsRating(){
        $rates = $this->hasMany(PostsRating::className(), ['post_id' => 'id'])->sum('score');
        return $rates;
    }

    public function getLink(){
        $cat = GlobalHelper::getCategoryUrlById($this->category_id);
        return Url::to(['post/full', 'cat' => $cat, 'id' => $this->id, 'alt' => $this->url]);
    }

    public function getFrontendLink(){
        $cat = GlobalHelper::getCategoryUrlById($this->category_id);
        return substr(\Yii::$app->params['frontendBaseUrl'], 0, -1).\Yii::$app->urlManagerFrontend->createUrl(['post/full', 'cat' => $cat, 'id' => $this->id, 'alt' => $this->url]);
    }

    public function getAbsoluteLink() {
        return \Yii::$app->params['frontendBaseUrl'].substr($this->link, 1);
    }

    public static function tableName(){
        return '{{%post}}';
    }
}