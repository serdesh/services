<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mapinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mi_id') ?>

    <?= $form->field($model, 'mi_name') ?>

    <?= $form->field($model, 'mi_parent_id') ?>

    <?= $form->field($model, 'mi_url') ?>

    <?php // echo $form->field($model, 'mi_add_permission') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
