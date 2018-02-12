<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ftpaccounts;

/**
 * FtpaccountsSearch represents the model behind the search form of `app\models\Ftpaccounts`.
 */
class FtpaccountsSearch extends Ftpaccounts {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ftp_id'], 'integer'],
            [['ftp_login', 'ftp_pass', 'ftp_path', 'ftp_site'], 'safe'],
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
        $query = Ftpaccounts::find();

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
            'ftp_id' => $this->ftp_id,
        ]);

        $query->andFilterWhere(['like', 'ftp_login', $this->ftp_login])
                ->andFilterWhere(['like', 'ftp_pass', $this->ftp_pass])
                ->andFilterWhere(['like', 'ftp_site', $this->ftp_site])
                ->andFilterWhere(['like', 'ftp_path', $this->ftp_path]);

        return $dataProvider;
    }

}
