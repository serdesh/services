<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VestnikSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vestnik-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'vest_id') ?>

    <?= $form->field($model, 'vest_number') ?>

    <?= $form->field($model, 'vest_numberlitera') ?>

    <?= $form->field($model, 'vest_pathfile') ?>

    <?= $form->field($model, 'vest_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
