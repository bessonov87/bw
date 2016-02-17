<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'edit_user', 'allow_comm', 'allow_main', 'allow_catlink', 'allow_similar', 'allow_rate', 'approve', 'fixed', 'category_art', 'inm', 'not_in_related'], 'integer'],
            [['date', 'short', 'full', 'title', 'meta_title', 'meta_descr', 'meta_keywords', 'url', 'edit_date', 'edit_reason'], 'safe'],
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
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'date' => $this->date,
            'edit_date' => $this->edit_date,
            'edit_user' => $this->edit_user,
            'allow_comm' => $this->allow_comm,
            'allow_main' => $this->allow_main,
            'allow_catlink' => $this->allow_catlink,
            'allow_similar' => $this->allow_similar,
            'allow_rate' => $this->allow_rate,
            'approve' => $this->approve,
            'fixed' => $this->fixed,
            'category_art' => $this->category_art,
            'inm' => $this->inm,
            'not_in_related' => $this->not_in_related,
        ]);

        $query->andFilterWhere(['like', 'short', $this->short])
            ->andFilterWhere(['like', 'full', $this->full])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_descr', $this->meta_descr])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'edit_reason', $this->edit_reason]);

        return $dataProvider;
    }
}
