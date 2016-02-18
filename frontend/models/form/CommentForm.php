<?php
namespace frontend\models\form;

use common\models\ar\Comment;
use common\models\ar\User;
use common\models\ar\Post;
use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;

class CommentForm extends Model
{
    public $user_id;
    public $post_id;
    public $reply_to;
    public $text;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and text are both required
            [['user_id', 'post_id', 'text'], 'required'],
            [['user_id', 'post_id', 'reply_to'], 'integer'],
            // rememberMe must be a boolean value
            //['text', 'string', ['min' => Yii::$app->params['comments']['min_length'], 'max' => Yii::$app->params['comments']['max_length']]],
            ['text', 'string', 'length' => [Yii::$app->params['comments']['min_length'], Yii::$app->params['comments']['max_length']]],
            // password is validated by validatePassword()
            ['post_id', 'exist',
                'targetClass' => '\common\models\ar\Post',
                'targetAttribute' => 'id',
                'filter' => ['approve' => Post::APPROVED],
                'message' => 'There is no post with such id.'
            ],
            ['user_id', 'exist',
                'targetClass' => '\common\models\ar\User',
                'targetAttribute' => 'id',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Вам запрещено оставлять комментарии. Возможно, это связано с тем, что вы не подтвердили свой email'
            ],
            ['user_id', 'compare', 'compareValue' => Yii::$app->user->identity->getId()],
        ];
    }

    public function addComment(){
        if ($this->validate()) {
            $comment = new Comment();
            $comment->user_id = $this->user_id;
            $comment->post_id = $this->post_id;
            if($this->reply_to) $comment->reply_to = $this->reply_to;
            $comment->ip = Yii::$app->request->getUserIP();
            $comment->is_register = 1;
            $comment->text_raw = $this->text;
            $comment->text = HtmlPurifier::process($this->text);
            if ($comment->save()) {
                return $comment->id;
            }
        }

        return null;
    }
}