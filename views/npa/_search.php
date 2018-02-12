<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NpaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="npa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'npa_id') ?>

    <?= $form->field($model, 'npa_number') ?>

    <?= $form->field($model, 'npa_literanumber') ?>

    <?= $form->field($model, 'npa_date_adoption') ?>

    <?= $form->field($model, 'npa_date_start') ?>

    <?php // echo $form->field($model, 'npa_sign_user_id') ?>

    <?php // echo $form->field($model, 'npa_vestnik_id') ?>

    <?php // echo $form->field($model, 'npa_div_id') ?>

    <?php // echo $form->field($model, 'npa_user_id') ?>

    <?php // echo $form->field($model, 'npa_path') ?>

    <?php // echo $form->field($model, 'npa_title') ?>

    <?php // echo $form->field($model, 'npa_text') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
