<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Organ */

$this->title = $model->organ_name;
$this->params['breadcrumbs'][] = ['label' => 'Органы власти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organ-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->organ_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->organ_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно удалить' . $this->title . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'organ_id',
            'organ_name',
            'organ_inn',
        ],
    ]) ?>

</div>
