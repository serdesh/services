<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mapinfo;

/**
 * MapinfoSearch represents the model behind the search form about `app\models\Mapinfo`.
 */
class MapinfoSearch extends Mapinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mi_id', 'mi_parent_id', 'mi_add_permission'], 'integer'],
            [['mi_name', 'mi_url'], 'safe'],
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
        $query = Mapinfo::find();

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
            'mi_id' => $this->mi_id,
            'mi_parent_id' => $this->mi_parent_id,
            'mi_add_permission' => $this->mi_add_permission,
        ]);

        $query->andFilterWhere(['like', 'mi_name', $this->mi_name])
            ->andFilterWhere(['like', 'mi_url', $this->mi_url]);

        return $dataProvider;
    }
}
