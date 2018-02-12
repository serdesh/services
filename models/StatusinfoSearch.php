<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Statusinfo;

/**
 * StatusinfoSearch represents the model behind the search form about `app\models\Statusinfo`.
 */
class StatusinfoSearch extends Statusinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stat_id'], 'integer'],
            [['stat_name'], 'safe'],
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
        $query = Statusinfo::find();

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
            'stat_id' => $this->stat_id,
        ]);

        $query->andFilterWhere(['like', 'stat_name', $this->stat_name]);

        return $dataProvider;
    }
}
