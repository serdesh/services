<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Oldsiteinfo */

$this->title = 'Update Oldsiteinfo: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Oldsiteinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oldsiteinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
