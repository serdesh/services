<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mapinfo */

$this->title = 'Добавление раздела';
$this->params['breadcrumbs'][] = ['label' => 'Карта сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapinfo-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
