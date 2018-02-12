<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ftpaccounts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ftpaccounts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ftp_login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ftp_pass')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'ftp_site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ftp_path')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
