<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ftpaccounts */

$this->title = 'Update Ftpaccounts: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Ftpaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ftp_id, 'url' => ['view', 'id' => $model->ftp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container ftpaccounts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
