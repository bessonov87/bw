<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    public $files = [];
    public $post_id;
    public $user_id;
    public $create_thumb;
    public $max_pixel;
    public $max_pixel_side;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'files'], 'required'],
            [['user_id', 'post_id', 'integer', 'create_thumb', 'max_pixel'], 'integer'],

            ['files', 'each', 'rule' => ['string']],
            ['post_id', 'exist',
                'targetClass' => '\common\models\ar\Post',
                'targetAttribute' => 'id',
                'message' => 'There is no post with such id.'
            ],
            ['user_id', 'exist',
                'targetClass' => '\common\models\ar\User',
                'targetAttribute' => 'id',
                'message' => 'There is no user with such id.'
            ],
        ];
    }

    public function upload(){
        var_dump($this->files);
    }
}