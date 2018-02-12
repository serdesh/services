<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <h1>Нихуа не работает!</h1>
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

    <?php echo $form->field($model, 'id')->textInput() ?>

    <?php echo $form->field($model, 'username')->textInput() ?>

    <?php echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <?php echo $form->field($model, 'role')->textInput() ?>

    <?php
    ?>

    <?php
    $items = yii\helpers\ArrayHelper::map(\app\models\Division::find()->all(), 'div_id', 'div_name');
    echo $form->field($model, 'division_id')->dropDownList($items, [
        'prompt' => 'Выберите подразделение',
    ])
    ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
