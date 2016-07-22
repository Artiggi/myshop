<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `frontend\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public $catName;

    public function rules()
    {
        return [
            [['id', 'count', 'cat_id'], 'integer'],
            [['name'], 'safe'],
            [['price'], 'number'],
            [['catName'], 'safe'],
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
        $query = Products::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'name', 'price', 'count',
                'catName' => [
                    'asc' => ['category.name' => SORT_ASC],
                    'desc' => ['category.name' => SORT_DESC],
                    'label' => 'Категория'
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {

        $query->joinWith(['cat']);
        return $dataProvider;

        }


        // grid filtering conditions
       
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'count' => $this->count,
        ]);
        
        //$query->andFilterWhere(['like', 'name', $this->name]);

        $query->joinWith(['cat' => function ($q) {
            $q->where('category.name LIKE "%' . $this->catName . '%"');
        }]);
        
        return $dataProvider;
    }
}
