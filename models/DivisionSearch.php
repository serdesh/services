<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Division;

/**
 * DivisionSearch represents the model behind the search form about `app\models\Division`.
 */
class DivisionSearch extends Division {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['div_id', 'div_boss'], 'integer'],
            [['div_name', 'div_note'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Division::find()->orderBy(['div_name' => ASC]);

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
            'div_id' => $this->div_id,
            'div_boss' => $this->div_boss,
        ]);

        $query->andFilterWhere(['like', 'div_name', $this->div_name])
                ->andFilterWhere(['like', 'div_note', $this->div_note]);

        return $dataProvider;
    }

}
