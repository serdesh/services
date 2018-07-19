<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['task_id', 'task_user', 'task_order', 'task_urgency', 'task_deleted'], 'integer'],
            [['task_description', 'task_notes', 'task_data', 'task_solution'], 'safe'],
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
        $query = Task::find()->where(['task_deleted'=> 0])->orderBy(['task_urgency' => SORT_ASC, 'task_order' => SORT_ASC]);
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
            'task_deleted' => $this->task_deleted,
        ]);

        $query->andFilterWhere(['like', 'task_description', $this->task_description])
                ->andFilterWhere(['like', 'task_notes', $this->task_notes])
                ->andFilterWhere(['like', 'task_solution', $this->task_solution]);

        return $dataProvider;
    }

}
