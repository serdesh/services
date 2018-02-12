<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SiteinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="siteinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'si_id') ?>

    <?= $form->field($model, 'si_user_id') ?>

    <?= $form->field($model, 'si_division_id') ?>

    <?= $form->field($model, 'si_data') ?>

    <?= $form->field($model, 'si_name_info') ?>

    <?php // echo $form->field($model, 'si_map_id') ?>

    <?php // echo $form->field($model, 'si_text') ?>

    <?php // echo $form->field($model, 'si_end_public') ?>

    <?php // echo $form->field($model, 'si_path_attach') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
