<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mapinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mapinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if ($model->mi_parent_id == '0') {
        $model->mi_parent_id = '239'; //"Раздел отсутствет"
    }
    echo $form->field($model, 'mi_parent_id')->dropDownList(app\models\Mapinfo::getList(), [
        'prompt' => 'Выберите родительский раздел',
    ])->label('Родитель');
    ?>

    <?= $form->field($model, 'mi_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mi_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mi_add_permission')->checkbox(['value' => 1, 'uncheckValue' => 0]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
