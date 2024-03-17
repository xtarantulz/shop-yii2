<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Page;

class PageSearch extends Page
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'content', 'created_at', 'updated_at', 'slug'], 'safe'],
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
        $query = Page::find();

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
            Page::tableName().'.id' => $this->id
        ]);

        $query->andFilterWhere(['like', Page::tableName().'.name', $this->name])
            ->andFilterWhere(['like', Page::tableName().'.content', $this->content])
            ->andFilterWhere(['like', Page::tableName().'.slug', $this->slug]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', Page::tableName().'.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Page::tableName().'.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', Page::tableName().'.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', Page::tableName().'.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        return $dataProvider;
    }
}
