<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vestnik */

$this->title = 'Вестник №' . $model->vest_fullnumber . ' от ' . date('d.m.Y', strtotime($model->vest_data));
$this->params['breadcrumbs'][] = ['label' => 'Вестники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container vestnik-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->vest_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->vest_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно удалить' . $this->title . '?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'vest_fullnumber',
            [
                'attribute' => 'vest_data',
                'value' => date('d.m.Y', strtotime($model->vest_data)),
            ],
            [
                    'attribute' => 'vest_pathfile',
                    'format' => 'raw',
                    'value' => \yii\helpers\Html::a($model->vest_pathfile, $model->vest_pathfile)
            ]

        ],
    ])
    ?>

</div>
