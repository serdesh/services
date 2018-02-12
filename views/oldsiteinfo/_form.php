<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Oldsiteinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oldsiteinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KONTORA_ID')->textInput() ?>

    <?= $form->field($model, 'DATA')->textInput() ?>

    <?= $form->field($model, 'NAME_INFO')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'RAZDEL')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'IP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NAME_COMP')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TEXT_INFO')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'END_PUBLIC_DATE')->textInput() ?>

    <?= $form->field($model, 'PATH_ATTACH')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
