<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ar\Goroskop;

/**
 * GoroskopDailySearch represents the model behind the search form about `common\models\ar\Goroskop`.
 */
class GoroskopSearch extends Goroskop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'zodiak', 'created_at', 'week', 'month', 'year', 'approve', 'views'], 'integer'],
            [['text', 'date', 'period', 'type'], 'safe'],
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
        $query = Goroskop::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'zodiak' => $this->zodiak,
            'created_at' => $this->created_at,
            'date' => $this->date,
            'week' => $this->week,
            'month' => $this->month,
            'year' => $this->year,
            'approve' => $this->approve,
            'views' => $this->views,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
