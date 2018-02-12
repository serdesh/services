<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */

$this->title = 'Update Seller: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sel_id, 'url' => ['view', 'id' => $model->sel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seller-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
