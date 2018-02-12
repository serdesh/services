<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Birthday */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="birthday-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'b_fio')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'b_datbirth')->textInput() ?>

    <?= $form->field($model, 'b_tel')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'b_yearbirth')->textInput() ?>

    <?= $form->field($model, 'b_notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
