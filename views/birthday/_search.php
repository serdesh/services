<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BirthdaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="birthday-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'b_id') ?>

    <?= $form->field($model, 'b_fio') ?>

    <?= $form->field($model, 'b_datbirth') ?>

    <?= $form->field($model, 'b_tel') ?>

    <?= $form->field($model, 'b_yearbirth') ?>

    <?php // echo $form->field($model, 'b_notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
