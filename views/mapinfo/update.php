<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mapinfo */

$this->title = 'Изменение раздела: ' . $model->mi_name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mi_name, 'url' => ['view', 'id' => $model->mi_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="mapinfo-update container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
