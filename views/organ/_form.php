<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Organ */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organ-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organ_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organ_inn')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
