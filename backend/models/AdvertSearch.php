<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advert;

/**
 * AdvertSearch represents the model behind the search form about `common\models\Advert`.
 */
class AdvertSearch extends Advert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'block_number', 'category', 'approve', 'on_request'], 'integer'],
            [['title', 'code', 'location', 'replacement_tag'], 'safe'],
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
        $query = Advert::find();

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
            'block_number' => $this->block_number,
            'category' => $this->category,
            'approve' => $this->approve,
            'on_request' => $this->on_request,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'replacement_tag', $this->replacement_tag]);

        return $dataProvider;
    }
}
