<?php

namespace common\models\search;

use common\models\Product;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at', 'slug'], 'safe'],
            [['price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/', 'max' => 9999999.99],
            [['price'], 'filter', 'filter' => function ($value) {
                $value = str_replace(',', '.', $value);
                return $value;
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()->joinWith(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'enableMultiSort' => true,
            'defaultOrder' => ['updated_at' => SORT_DESC]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            Product::tableName() . '.id' => $this->id,
            Product::tableName() . '.category_id' => $this->category_id,
            Product::tableName() . '.price' => $this->price,
        ]);

        $query->andFilterWhere(['like', Product::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', Product::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', Product::tableName() . '.slug', $this->slug]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Product::tableName() . '.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Product::tableName() . '.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Product::tableName() . '.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Product::tableName() . '.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        return $dataProvider;
    }
}
