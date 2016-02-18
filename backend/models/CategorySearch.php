<?php

namespace backend\models;

use common\models\ar\Post;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ar\Category;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{
    public $postCount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'post_num', 'category_art'], 'integer'],
            [['name', 'url', 'icon', 'description', 'meta_title', 'meta_descr', 'meta_keywords', 'post_sort', 'short_view', 'full_view', 'header', 'footer', 'add_method'], 'safe'],
            [['postCount'], 'safe'],
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
        $query = Category::find();

        $subQuery = Post::find()
            ->select('category_id, count(id) as post_count')
            ->groupBy('category_id');
        //var_dump($subQuery);

        $query->leftJoin(['postsNum' => $subQuery], 'postsNum.category_id = id');

        $query->select('category.*, postsNum.post_count');

        //$query->select('category.*, count(post.id) as countP')->joinWith('postCount')->groupBy('category.id');
        //$query->join('LEFT JOIN', '{{%post}}', [$this->tableName().'.id' => '{{%post}}.category_id']);
        //$query->select('category.*, count(post.*)')->joinWith('posts',true,'LEFT OUTER JOIN')->groupBy('category.id');

        //var_dump($query->);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //var_dump($dataProvider);



        /**
         * Setup your sorting attributes
         * Note: This is setup before the $this->load($params)
         * statement below
         */
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'parent_id',
                'name',
                'url',
                'category_art',
                'add_method',
                'postCount' => [
                    'asc' => ['postsNum.post_count' => SORT_ASC],
                    'desc' => ['postsNum.post_count' => SORT_DESC],
                    'label' => 'Order Name'
                ]
            ]
        ]);






        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // filter by order amount
        $query->andFilterWhere(['postsNum.post_count' => $this->postCount]);

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'post_num' => $this->post_num,
            'category_art' => $this->category_art,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_descr', $this->meta_descr])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'post_sort', $this->post_sort])
            ->andFilterWhere(['like', 'short_view', $this->short_view])
            ->andFilterWhere(['like', 'full_view', $this->full_view])
            ->andFilterWhere(['like', 'header', $this->header])
            ->andFilterWhere(['like', 'footer', $this->footer])
            ->andFilterWhere(['like', 'header', $this->add_method]);

        return $dataProvider;
    }
}
