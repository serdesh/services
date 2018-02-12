<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Division */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="division-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'div_name')->textInput(['maxlength' => true]) ?>
    
    <?php 
        $dd_items = yii\helpers\ArrayHelper::map(app\models\User::find()->orderBy(['fio' => SORT_ASC])->all(), 'id', 'fio')
    ?>
    
    <?= $form->field($model, 'div_boss')->dropDownList($dd_items,[
        'prompt' => 'Выберите руководителя подразделения'
    ]) ?>

    <?= $form->field($model, 'div_note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
