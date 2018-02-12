<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sel_name')->textInput(['maxlength' => true])->label('Наименование') ?>

    <?= $form->field($model, 'sel_phone')->textInput(['maxlength' => true])->label('Телефон') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
