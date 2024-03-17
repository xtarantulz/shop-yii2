<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Field;

class FieldSearch extends Field
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_after_point'], 'integer'],
            [['name', 'type', 'options', 'prefix', 'suffix', 'description', 'expansions', 'created_at', 'updated_at'], 'safe'],
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
        $query = Field::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'enableMultiSort' => true,
            'defaultOrder' => ['name' => SORT_ASC]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            Field::tableName().'.id' => $this->id,
            Field::tableName().'.number_after_point' => $this->number_after_point,
        ]);

        $query->andFilterWhere(['like', Field::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Field::tableName().'.type', $this->type])
            ->andFilterWhere(['like', Field::tableName().'.options', $this->options])
            ->andFilterWhere(['like', Field::tableName().'.prefix', $this->prefix])
            ->andFilterWhere(['like', Field::tableName().'.suffix', $this->suffix])
            ->andFilterWhere(['like', Field::tableName().'.description', $this->description])
            ->andFilterWhere(['like', Field::tableName().'.expansions', $this->expansions]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Field::tableName().'.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Field::tableName().'.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Field::tableName().'.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Field::tableName().'.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        return $dataProvider;
    }
}
