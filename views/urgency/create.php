<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Urgency */

$this->title = 'Create Urgency';
$this->params['breadcrumbs'][] = ['label' => 'Urgencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="urgency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
