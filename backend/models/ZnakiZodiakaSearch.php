<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZnakiZodiaka;

/**
 * ZnakiZodiakaSearch represents the model behind the search form about `common\models\ZnakiZodiaka`.
 */
class ZnakiZodiakaSearch extends ZnakiZodiaka
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'znak_id', 'created_at', 'updated_at'], 'integer'],
            [['element', 'planet', 'opposite', 'stone', 'color', 'compatibility', 'common', 'man', 'woman', 'child', 'career', 'health'], 'safe'],
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
        $query = ZnakiZodiaka::find();

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
            'znak_id' => $this->znak_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'element', $this->element])
            ->andFilterWhere(['like', 'planet', $this->planet])
            ->andFilterWhere(['like', 'opposite', $this->opposite])
            ->andFilterWhere(['like', 'stone', $this->stone])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'compatibility', $this->compatibility])
            ->andFilterWhere(['like', 'common', $this->common])
            ->andFilterWhere(['like', 'man', $this->man])
            ->andFilterWhere(['like', 'woman', $this->woman])
            ->andFilterWhere(['like', 'child', $this->child])
            ->andFilterWhere(['like', 'career', $this->career])
            ->andFilterWhere(['like', 'health', $this->health]);

        return $dataProvider;
    }
}
