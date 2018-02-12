<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Birthday */

$this->title = $model->b_id;
$this->params['breadcrumbs'][] = ['label' => 'Birthdays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="birthday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->b_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->b_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'b_id',
            'b_fio:ntext',
            'b_datbirth',
            'b_tel:ntext',
            'b_yearbirth',
            'b_notes:ntext',
        ],
    ]) ?>

</div>
