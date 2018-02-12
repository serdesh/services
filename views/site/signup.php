<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container sit-signup">
    <h1><?= Html::encode($this->title); ?> </h1>
    <div class="row">
        <div class="col-lg-5">
            
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?php // echo $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'fio')->textinput(['placeholder' => 'Фамилия, имя, отчество полностью', 'autofocus' => true])->hint('') ?>

            <?php
            $items = yii\helpers\ArrayHelper::map(\app\models\Division::find()->all(), 'div_id', 'div_name');
            echo $form->field($model, 'division_id')->dropDownList($items, [
                'prompt' => 'Выберите подразделение',
            ])->label('Подразделение')
            ?>

            <?php // $form->field($model, 'email')->input('email')->hint('Введите адрес электронной почты') ?>

            <?= $form->field($model, 'password')->passwordInput()->hint('Придумайте пароль') ?>
            
            <?= $form->field($model, 'password_repeat')->passwordInput()->hint('Повторите пароль') ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

        
    </div>
</div>
