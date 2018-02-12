<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Npa;

/**
 * NpaSearch represents the model behind the search form about `app\models\Npa`.
 */
class NpaSearch extends Npa {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['npa_id', 'npa_number', 'npa_sign_user_id', 'npa_vestnik_id', 'npa_div_id', 'npa_user_id', 'npa_view_id', 'npa_type_id'], 'integer'],
            [['npa_literanumber', 'npa_fullnumber', 'npa_date_adoption', 'npa_date_start', 'npa_path', 'npa_title', 'npa_text'], 'safe'],
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
        $query = Npa::find();
        $query->orderBy(['npa_date_adoption' => SORT_DESC, 'npa_fullnumber' => SORT_DESC]);
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
            'npa_id' => $this->npa_id,
            'npa_number' => $this->npa_number,
            'npa_date_adoption' => $this->npa_date_adoption,
            'npa_date_start' => $this->npa_date_start,
            'npa_sign_user_id' => $this->npa_sign_user_id,
            'npa_vestnik_id' => $this->npa_vestnik_id,
            'npa_div_id' => $this->npa_div_id,
            'npa_user_id' => $this->npa_user_id,
            'npa_view_id' => $this->npa_view_id,
            'npa_type_id' => $this->npa_type_id,
        ]);

        $query->andFilterWhere(['like', 'npa_literanumber', $this->npa_literanumber])
                ->andFilterWhere(['like', 'npa_fullnumber', $this->npa_fullnumber])
                ->andFilterWhere(['like', 'npa_path', $this->npa_path])
                ->andFilterWhere(['like', 'npa_title', $this->npa_title])
                ->andFilterWhere(['like', 'npa_text', $this->npa_text]);

        return $dataProvider;
    }

}
