<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Тестовая страница';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container site-test">
    <h1><?= Html::encode($this->title); ?> </h1>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
            ]); ?>

            <?= $form->field($model, 'files[]')->fileInput([
                'multiple' => true,
                'class' => 'btn btn-default btn-block',
            ])->label('Вложения (Выбирать файлы необходимо все и сразу!)'); ?>

            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary', 'name' => 'signup-button']); ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <?php \yii\helpers\VarDumper::dump($model, 5, true) ?>
</div>