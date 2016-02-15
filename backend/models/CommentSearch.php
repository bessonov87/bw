<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'reply_to', 'post_id', 'user_id', 'is_register', 'approve'], 'integer'],
            [['date', 'email', 'text_raw', 'text', 'ip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orderBy(['date' => SORT_DESC]);

        $query->andFilterWhere([
            'id' => $this->id,
            'reply_to' => $this->reply_to,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'is_register' => $this->is_register,
            'approve' => $this->approve,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'text_raw', $this->text_raw])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
