<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Birthday */

$this->title = 'Update Birthday: ' . $model->b_id;
$this->params['breadcrumbs'][] = ['label' => 'Birthdays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->b_id, 'url' => ['view', 'id' => $model->b_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="birthday-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
