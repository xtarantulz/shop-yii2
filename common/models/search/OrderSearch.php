<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['fullName', 'first_name', 'last_name', 'middle_name', 'phone', 'email', 'updated_at', 'created_at'], 'safe'],
            [['total'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/', 'max' => 9999999.99],
            [['total'], 'filter', 'filter' => function ($value) {
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
        $query = Order::find()->joinWith(['user'])->select([
            'order.*',
            'fullName' => 'CONCAT('.Order::tableName().'.first_name, " ", '.Order::tableName().'.last_name, " ", '.Order::tableName().'.middle_name)'
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'enableMultiSort' => true,
            'defaultOrder' => ['created_at' => SORT_DESC]
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['fullName'] = [
            'asc' => ['fullName' => SORT_ASC],
            'desc' => ['fullName' => SORT_DESC],
        ];

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            Order::tableName() . '.id' => $this->id,
            Order::tableName() . '.user_id' => $this->user_id,
            Order::tableName() . '.total' => $this->total,
            Order::tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Order::tableName() . '.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Order::tableName() . '.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Order::tableName() . '.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Order::tableName() . '.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        if($this->fullName){
            $query->andFilterHaving(['like', 'fullName', $this->fullName]);
        }

        return $dataProvider;
    }
}
