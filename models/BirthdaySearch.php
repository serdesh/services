<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Birthday;

/**
 * BirthdaySearch represents the model behind the search form about `app\models\Birthday`.
 */
class BirthdaySearch extends Birthday
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_id', 'b_datbirth', 'b_yearbirth'], 'integer'],
            [['b_fio', 'b_tel', 'b_notes'], 'safe'],
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
        $query = Birthday::find();

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
            'b_id' => $this->b_id,
            'b_datbirth' => $this->b_datbirth,
            'b_yearbirth' => $this->b_yearbirth,
        ]);

        $query->andFilterWhere(['like', 'b_fio', $this->b_fio])
            ->andFilterWhere(['like', 'b_tel', $this->b_tel])
            ->andFilterWhere(['like', 'b_notes', $this->b_notes]);

        return $dataProvider;
    }
}
