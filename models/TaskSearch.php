<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['task_id', 'task_user', 'task_order', 'task_urgency'], 'integer'],
            [['task_description', 'task_notes', 'task_data'], 'safe'],
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
        $query = Task::find()->orderBy(['task_urgency' => 'DESC']);
        //$query = Task::find();
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
            'task_order' => $this->task_order,
            'task_urgency' => $this->task_urgency,
            'task_id' => $this->task_id,
            'task_user' => $this->task_user,
            'task_data' => $this->task_data,
        ]);

        $query->andFilterWhere(['like', 'task_description', $this->task_description])
                ->andFilterWhere(['like', 'task_notes', $this->task_notes]);

        return $dataProvider;
    }

}
