<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vestnik;

/**
 * VestnikSearch represents the model behind the search form about `app\models\Vestnik`.
 */
class VestnikSearch extends Vestnik {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['vest_id', 'vest_number', 'vest_stat'], 'integer'],
            [['vest_numberlitera', 'vest_pathfile', 'vest_data', 'vest_fullnumber'], 'safe'],
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
        $query = Vestnik::find();
        $query->orderBy(['vest_data' => SORT_DESC]);
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
            'vest_id' => $this->vest_id,
            'vest_number' => $this->vest_number,
            'vest_data' => $this->vest_data,
            'vest_stat' => $this->vest_stat,
        ]);

        $query->andFilterWhere(['like', 'vest_numberlitera', $this->vest_numberlitera])
                ->andFilterWhere(['like', 'vest_pathfile', $this->vest_pathfile])
                ->andFilterWhere(['like', 'vest_fullnumber', $this->vest_pathfile]);

        return $dataProvider;
    }

}
