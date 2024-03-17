<?php

namespace common\models\search;

use common\models\Category;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'sort_order'], 'integer'],
            [['name', 'created_at', 'updated_at', 'description', 'alias'], 'safe'],
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
        $query = Category::find()->joinWith(['parent']);

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
            Category::tableName() . '.id' => $this->id,
            Category::tableName() . '.parent_id' => $this->parent_id,
            Category::tableName() . '.sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', Category::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', Category::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', Category::tableName() . '.alias', $this->alias]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Category::tableName() . '.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Category::tableName() . '.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Category::tableName() . '.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Category::tableName() . '.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        return $dataProvider;
    }
}
