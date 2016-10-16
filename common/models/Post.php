<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $date
 * @property integer $category_id
 * @property string $short
 * @property string $full
 * @property string $title
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_keywords
 * @property string $url
 * @property string $related
 * @property integer $prev_page
 * @property integer $next_page
 * @property integer $views
 * @property integer $edit_date
 * @property integer $edit_user
 * @property string $edit_reason
 * @property integer $allow_comm
 * @property integer $allow_main
 * @property integer $allow_catlink
 * @property integer $allow_similar
 * @property integer $allow_rate
 * @property integer $allow_ad
 * @property integer $approve
 * @property integer $fixed
 * @property integer $category_art
 * @property integer $inm
 * @property integer $not_in_related
 * @property integer $skin
 *
 * @property Comment[] $comments
 * @property FavoritePosts[] $favoritePosts
 * @property Files[] $files
 * @property Category $category
 * @property User $author
 * @property PostCategory[] $postCategories
 * @property PostsRating[] $postsRatings
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'date', 'category_id', 'short', 'full', 'title', 'url'], 'required'],
            [['author_id', 'date', 'category_id', 'prev_page', 'next_page', 'views', 'edit_date', 'edit_user', 'allow_comm', 'allow_main', 'allow_catlink', 'allow_similar', 'allow_rate', 'allow_ad', 'approve', 'fixed', 'category_art', 'inm', 'not_in_related', 'skin'], 'integer'],
            [['short', 'full'], 'string'],
            [['title', 'meta_title', 'meta_descr', 'meta_keywords', 'url', 'related', 'edit_reason'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
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
            'category_id' => 'Category ID',
            'short' => 'Short',
            'full' => 'Full',
            'title' => 'Title',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Descr',
            'meta_keywords' => 'Meta Keywords',
            'url' => 'Url',
            'related' => 'Related',
            'prev_page' => 'Prev Page',
            'next_page' => 'Next Page',
            'views' => 'Views',
            'edit_date' => 'Edit Date',
            'edit_user' => 'Edit User',
            'edit_reason' => 'Edit Reason',
            'allow_comm' => 'Allow Comm',
            'allow_main' => 'Allow Main',
            'allow_catlink' => 'Allow Catlink',
            'allow_similar' => 'Allow Similar',
            'allow_rate' => 'Allow Rate',
            'allow_ad' => 'Allow Ad',
            'approve' => 'Approve',
            'fixed' => 'Fixed',
            'category_art' => 'Category Art',
            'inm' => 'Inm',
            'not_in_related' => 'Not In Related',
            'skin' => 'Skin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
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
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostsRatings()
    {
        return $this->hasMany(PostsRating::className(), ['post_id' => 'id']);
    }
}
