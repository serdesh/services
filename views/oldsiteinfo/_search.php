<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OldsiteinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oldsiteinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KONTORA_ID') ?>

    <?= $form->field($model, 'DATA') ?>

    <?= $form->field($model, 'NAME_INFO') ?>

    <?= $form->field($model, 'RAZDEL') ?>

    <?php // echo $form->field($model, 'IP') ?>

    <?php // echo $form->field($model, 'NAME_COMP') ?>

    <?php // echo $form->field($model, 'TEXT_INFO') ?>

    <?php // echo $form->field($model, 'END_PUBLIC_DATE') ?>

    <?php // echo $form->field($model, 'PATH_ATTACH') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
