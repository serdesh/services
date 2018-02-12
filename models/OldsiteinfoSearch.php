<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Oldsiteinfo;

/**
 * OldsiteinfoSearch represents the model behind the search form about `app\models\Oldsiteinfo`.
 */
class OldsiteinfoSearch extends Oldsiteinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'KONTORA_ID'], 'integer'],
            [['DATA', 'NAME_INFO', 'RAZDEL', 'IP', 'NAME_COMP', 'TEXT_INFO', 'END_PUBLIC_DATE', 'PATH_ATTACH'], 'safe'],
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
        $query = Oldsiteinfo::find();

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
            'KONTORA_ID' => $this->KONTORA_ID,
            'DATA' => $this->DATA,
            'END_PUBLIC_DATE' => $this->END_PUBLIC_DATE,
        ]);

        $query->andFilterWhere(['like', 'NAME_INFO', $this->NAME_INFO])
            ->andFilterWhere(['like', 'RAZDEL', $this->RAZDEL])
            ->andFilterWhere(['like', 'IP', $this->IP])
            ->andFilterWhere(['like', 'NAME_COMP', $this->NAME_COMP])
            ->andFilterWhere(['like', 'TEXT_INFO', $this->TEXT_INFO])
            ->andFilterWhere(['like', 'PATH_ATTACH', $this->PATH_ATTACH]);

        return $dataProvider;
    }
}
