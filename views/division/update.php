<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Division */

$this->title = 'Редактирование: ' . $model->div_name;
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->div_name, 'url' => ['view', 'id' => $model->div_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="division-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
