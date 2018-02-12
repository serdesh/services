<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Urgency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="urgency-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'urg_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urg_description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
