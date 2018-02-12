<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vestnik */

$this->title = 'Update Vestnik: ' . $model->vest_id;
$this->params['breadcrumbs'][] = ['label' => 'Vestniks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vest_id, 'url' => ['view', 'id' => $model->vest_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vestnik-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
