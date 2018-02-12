<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DivisionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="division-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'div_id') ?>

    <?= $form->field($model, 'div_name') ?>
    
    <?= $form->field($model, 'div_boss') ?>

    <?= $form->field($model, 'div_note') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
