<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */

$this->title = 'Изменение ифнормации: ' . $model->si_name_info;
$this->params['breadcrumbs'][] = ['label' => 'Информация для сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->si_name_info, 'url' => ['view', 'id' => $model->si_id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="container siteinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
