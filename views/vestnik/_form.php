<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Vestnik */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vestnik-form">
    <div class="container">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'vest_number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'vest_numberlitera')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'vest_data')->Input('date', ['value' => date('Y-m-d')]) ?>
            </div>
            <div class="col-md-6">
                <?php //echo $form->field($model, 'vest_pathfile')->textInput(['maxlength' => true]) ?>
                <?php
                if ($model->isNewRecord) {
                    echo $form->field($model, 'file')->fileInput([
                        'multiple' => FALSE,
                        'class' => 'btn btn-default btn-block',
                    ])->label('Вложение');
                } else {
                    $dir = $model->vest_pathfile;
                    echo '<span><b>Вложение<b></span>';
                    echo Html::a($dir, Url::to(['/vestnik/files', 'id' => $model->vest_id]), ['class' => 'btn btn-info view-files btn-block', 'target' => 'blank']);
                }
                ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-10">
                <?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary btn-block']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
