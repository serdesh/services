<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Statusinfo */

$this->title = 'Update Statusinfo: ' . $model->stat_id;
$this->params['breadcrumbs'][] = ['label' => 'Statusinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stat_id, 'url' => ['view', 'id' => $model->stat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="statusinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
