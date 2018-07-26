<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <div class="container">
        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?php
        $listrole = yii\helpers\ArrayHelper::map(\app\models\Role::find()->all(), 'role_id', 'role_name');
        echo $form->field($model, 'role')->dropDownList($listrole, [
           'prompt' => 'Выберите роль пользователя' 
        ]);
        ?>

        <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

        <?php
        $items = yii\helpers\ArrayHelper::map(\app\models\Division::find()->all(), 'div_id', 'div_name');
        echo $form->field($model, 'division_id')->dropDownList($items, [
            'prompt' => 'Выберите подразделение',
        ])->label('Подразделение')
        ?>

        <?= $form->field($model, 'yandexMailUID')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
