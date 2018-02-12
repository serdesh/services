<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Organ */

$this->title = 'Добавление органа';
$this->params['breadcrumbs'][] = ['label' => 'Органы власти', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organ-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
