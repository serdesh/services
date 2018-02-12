<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = 'Задача ' . $model->task_id;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены, что хотите удалить задачу ' . $model-> task_id . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'task_id',
            'task_description:ntext',
            'task_notes:ntext',
            //'task_user',
            [
                'attribute' => 'task_user',
                'value' => function($data){
                    return app\models\User::findOne(['id' => $data->task_user])->fio;
                }
            ],
            //'task_order',
            //'task_urgency',
            [
                'attribute' => 'task_urgency',
                'value' => function($data) {
                    return \app\models\Urgency::findOne(['urg_id' => $data->task_urgency])->urg_name;
                }
            ],
            //'task_data',
                    [
                        'attribute' => 'task_data',
                        'value' => date('d.m.Y H:i', strtotime($model->task_data))
                    ],
        ],
    ]) ?>

</div>
