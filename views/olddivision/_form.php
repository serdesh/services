<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Olddivision */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="olddivision-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAME')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NOTES')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
