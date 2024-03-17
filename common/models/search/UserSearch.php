<?php

namespace common\models\search;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['fullName', 'first_name', 'last_name', 'phone', 'photo', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'role', 'created_at', 'updated_at'], 'safe'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->select([
            '*',
            'fullName' => 'CONCAT('.User::tableName().'.first_name, " ", '.User::tableName().'.last_name, " ", '.User::tableName().'.middle_name)'
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
            User::tableName().'.id' => $this->id,
            User::tableName().'.status' => $this->status,
            User::tableName().'.role' => $this->role,
        ]);

        $query->andFilterWhere(['like', User::tableName().'.first_name', $this->first_name])
            ->andFilterWhere(['like', User::tableName().'.last_name', $this->last_name])
            ->andFilterWhere(['like', User::tableName().'.phone', $this->phone])
            ->andFilterWhere(['like', User::tableName().'.photo', $this->photo])
            ->andFilterWhere(['like', User::tableName().'.auth_key', $this->auth_key])
            ->andFilterWhere(['like', User::tableName().'.password_hash', $this->password_hash])
            ->andFilterWhere(['like', User::tableName().'.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', User::tableName().'.email', $this->email]);

        if ($this->created_at) {
            $query->andFilterWhere(['>=', User::tableName().'.created_at', strtotime($this->created_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', User::tableName().'.created_at', strtotime($this->created_at . " 23:59:59")]);
        }

        if ($this->updated_at) {
            $query->andFilterWhere(['>=', User::tableName().'.updated_at', strtotime($this->updated_at . " 00:00:00")]);
            $query->andFilterWhere(['<=', User::tableName().'.updated_at', strtotime($this->updated_at . " 23:59:59")]);
        }

        if($this->fullName){
            $query->andFilterHaving(['like', 'fullName', $this->fullName]);
        }

        return $dataProvider;
    }
}
