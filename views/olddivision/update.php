<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Olddivision */

$this->title = 'Update Olddivision: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Olddivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="olddivision-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
