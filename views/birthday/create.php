<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Birthday */

$this->title = 'Create Birthday';
$this->params['breadcrumbs'][] = ['label' => 'Birthdays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="birthday-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
