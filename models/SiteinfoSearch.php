<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Siteinfo;

/**
 * SiteinfoSearch represents the model behind the search form about `app\models\Siteinfo`.
 */
class SiteinfoSearch extends Siteinfo {

    public $employee;
    public $divisions;
    public $section;
    

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['si_id', 'si_user_id', 'si_division_id', 'si_map_id', 'si_status'], 'integer'],
            [['si_data', 'si_name_info', 'si_text', 'si_end_public', 'si_path_attach'], 'safe'],
            [['employee', 'divisions', 'section'], 'safe'],
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
        $query = Siteinfo::find();
        $query->orderBy(['si_data' => SORT_DESC]);
        
        // add conditions that should always apply here
        $query->joinWith(['employee', 'divisions', 'section']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['employee'] = [
            'asc' => ['tbl_user.fio' => SORT_ASC],
            'desc' => ['tbl_user.fio' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['divisions'] = [
            'asc' => ['tbl_division.div_name' => SORT_ASC],
            'desc' => ['tbl_division.div_name' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['section'] = [
            'asc' => ['tbl_mapinfo.mi_name' => SORT_ASC],
            'desc' => ['tbl_mapinfo.mi_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'si_id' => $this->si_id,
            'si_user_id' => $this->si_user_id,
            'si_division_id' => $this->si_division_id,
            'si_map_id' => $this->si_map_id,
            'si_end_public' => $this->si_end_public,
            'si_status' => $this->si_status,
        ]);

        $query->andFilterWhere(['like', 'si_name_info', $this->si_name_info])
                ->andFilterWhere(['like', 'si_data', $this->si_data])
                ->andFilterWhere(['like', 'si_text', $this->si_text])
                ->andFilterWhere(['like', 'si_path_attach', $this->si_path_attach])
                ->andFilterWhere(['like', 'tbl_user.fio', $this->employee])
                ->andFilterWhere(['like', 'tbl_division.div_name', $this->divisions])
                ->andFilterWhere(['like', 'tbl_mapinfo.mi_name', $this->section])
                ;

        return $dataProvider;
    }

}
