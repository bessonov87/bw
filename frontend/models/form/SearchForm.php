<?php
namespace frontend\models\form;

use yii\base\Model;
use Yii;

/**
 * Поисковая форма
 */
class SearchForm extends Model
{
    public $story;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['story', 'filter', 'filter' => 'trim'],
            ['story', 'required'],
            ['story', 'string', 'min' => 3, 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'story' => 'Поисковая фраза',
        ];
    }
}