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
    public $on_server;
    public $watermark;
    public $folder = 'files';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'files'], 'required'],
            [['user_id', 'max_pixel'], 'integer'],
            ['max_pixel_side','in','range'=>['width','height'],'strict'=>false],
            [['create_thumb', 'watermark', 'post_id'], 'safe'],
            [['on_server'], 'string'],
            [['files'], 'file', 'skipOnEmpty' => 'false', 'maxFiles' => 10],
            ['user_id', 'exist',
                'targetClass' => '\common\models\ar\User',
                'targetAttribute' => 'id',
                'message' => 'There is no user with such id.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'create_thumb' => 'Создавать уменьшенную копию',
            'watermark' => 'Добавлять водяной знак',
        ];
    }

    public function upload(){
        var_dump($this);
    }
}