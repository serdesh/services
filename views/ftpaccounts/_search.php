<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FtpaccountsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ftpaccounts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'ftp_id') ?>

    <?= $form->field($model, 'ftp_login') ?>

    <?= $form->field($model, 'ftp_pass') ?>

    <?= $form->field($model, 'ftp_path') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
