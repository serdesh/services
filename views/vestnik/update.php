<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vestnik */
$litera = $model->vest_numberlitera;
$number = $model->vest_number;
if ($litera){
    $fullNum = $number . '-' . $litera;
} else {
    $fullNum = $number;
}

$this->title = 'Изменение вестника: ' . $fullNum;
$this->params['breadcrumbs'][] = ['label' => 'Вестники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fullNum, 'url' => ['view', 'id' => $model->vest_id]];
$this->params['breadcrumbs'][] = 'Правка';
?>
<div class="container vestnik-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
