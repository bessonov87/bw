<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $author_id
 * @property string $date
 * @property string $short
 * @property string $full
 * @property string $title
 * @property string $meta_title
 * @property string $meta_descr
 * @property string $meta_keywords
 * @property string $url
 * @property string $edit_date
 * @property string $edit_user
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
 *
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'short', 'full', 'title', 'url'], 'required'],
            [['author_id', 'edit_user', 'allow_comm', 'allow_main', 'allow_catlink', 'allow_similar', 'allow_rate', 'allow_ad', 'approve', 'fixed', 'category_art', 'inm', 'not_in_related'], 'integer'],
            [['date', 'edit_date'], 'safe'],
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
            'author_id' => 'ID Автора',
            'date' => 'Дата',
            'short' => 'Краткий текст',
            'full' => 'Полный текст',
            'title' => 'Заголовок',
            'meta_title' => 'Meta Title',
            'meta_descr' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'url' => 'Url',
            'edit_date' => 'Дата редактирования',
            'edit_user' => 'Редактор',
            'edit_reason' => 'Причина редактирования',
            'allow_comm' => 'Разрешить комментарии',
            'allow_main' => 'Публиковать на главной',
            'allow_catlink' => 'Разрешить ссылки на категории',
            'allow_similar' => 'Разрешить похожие статьи',
            'allow_rate' => 'Разрешить рейтинг',
            'allow_ad' => 'Публиковать рекламу?',
            'approve' => 'Разрешить статью?',
            'fixed' => 'Зафиксировать статью?',
            'category_art' => 'Статья-категория?',
            'inm' => 'Inm',
            'not_in_related' => 'Не выбирать в качестве похожей для других статей',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
