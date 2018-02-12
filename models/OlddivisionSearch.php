<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Olddivision;

/**
 * OlddivisionSearch represents the model behind the search form about `app\models\Olddivision`.
 */
class OlddivisionSearch extends Olddivision
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['NAME', 'NOTES'], 'safe'],
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
        $query = Olddivision::find();

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
            'ID' => $this->ID,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'NOTES', $this->NOTES]);

        return $dataProvider;
    }
}
