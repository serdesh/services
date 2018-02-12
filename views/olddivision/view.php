<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Olddivision */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Olddivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="olddivision-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
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
            'ID',
            'NAME:ntext',
            'NOTES:ntext',
        ],
    ]) ?>

</div>
