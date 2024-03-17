<?php

namespace common\models\search;

use common\models\Map;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MapSearch extends Map
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'sort_order', 'page_id'], 'integer'],
            [['name', 'controller', 'action', 'created_at', 'updated_at', 'description'], 'safe'],
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
        $query = Map::find()->joinWith(['parent', 'page']);

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
            Map::tableName() . '.id' => $this->id,
            Map::tableName() . '.parent_id' => $this->parent_id,
            Map::tableName() . '.sort_order' => $this->sort_order,
            Map::tableName() . '.page_id' => $this->page_id,
        ]);

        $query->andFilterWhere(['like', Map::tableName() . '.name', $this->name])
            ->andFilterWhere(['like', Map::tableName() . '.controller', $this->controller])
            ->andFilterWhere(['like', Map::tableName() . '.action', $this->action]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Map::tableName() . '.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Map::tableName() . '.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Map::tableName() . '.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Map::tableName() . '.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        return $dataProvider;
    }
}
