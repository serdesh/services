<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organ */

$this->title = 'Update Organ: ' . $model->organ_id;
$this->params['breadcrumbs'][] = ['label' => 'Organs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->organ_id, 'url' => ['view', 'id' => $model->organ_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organ-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
