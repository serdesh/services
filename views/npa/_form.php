<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\User;
use app\models\Division;
use app\models\Npaview;
use app\models\Npatype;

/* @var $this yii\web\View */
/* @var $model app\models\Npa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="npa-form">


    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php $view_items = ArrayHelper::map(Npaview::find()->all(), 'nview_id', 'nview_name') ?>
            <?= $form->field($model, 'npa_view_id')->dropDownList($view_items)->label('Вид документа') ?>
        </div>
        <div class="col-md-6">
            <?php $type_items = ArrayHelper::map(Npatype::find()->all(), 'ntype_id', 'ntype_name') ?>
            <?= $form->field($model, 'npa_type_id')->dropDownList($type_items)->label('Тип документа') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'npa_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'npa_literanumber')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'npa_date_adoption')->Input('date', ['value' => date('Y-m-d')]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'npa_date_start')->Input('date', ['value' => date('Y-m-d')]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $items = ArrayHelper::map(User::find()->andWhere(['role' => '3'])->orWhere(['role' => '4'])->all(), 'id', 'fio'); ?>
            <?= $form->field($model, 'npa_sign_user_id')->dropDownList($items) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $div_items = ArrayHelper::map(Division::find()->orderBy(['div_name' => 'ASC'])->all(), 'div_id', 'div_name'); ?>
            <?= $form->field($model, 'npa_div_id')->dropDownList($div_items, ['prompt' => 'Выберите подразделение'])->label('Подразделение, ответственное за подготовку') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'npa_title')->textarea(['rows' => 6, 'placeholder' => 'Например: Об утверждении отчета о реализации программы оздоровления муниципальных финансов за  1 полугодие 2017 года']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'npa_text')->textarea(['rows' => 6, 'placeholder' => 'Например: Руководствуясь Соглашением №15 от 25.01.2017 года «О мерах по повышению эффективности использования бюджетных средств и увеличению поступлений налоговых и неналоговых доходов местного бюджета Шарьинского муниципального района», заключённого между департаментом финансов Костромской области и администрацией Шарьинского муниципального района, а также п.19 ч.1 ст. 36,ст.38,42 Устава муниципального образования Шарьинский муниципальный район...'])->label('текст документа')->label('Текст документа (вместе с приложениями)') ?>
        </div>
    </div>
    <?php //echo $form->field($model, 'npa_path')->textInput(['maxlength' => true]) ?>
    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'file')->fileInput([
            'multiple' => false,
            'class' => 'btn btn-default btn-block',
        ])->label('Документ вместе с приложениями (одним файлом)');
    } else {
        echo Html::tag('div', Html::a('Просмотр прикрепленных файлов:<br>' . basename($model->npa_path), $model->npa_path, ['class' => 'btn btn-info', 'target' => 'blank']), ['class' => 'col-md-3'])  ; //Url::to(['/npa/files', 'id' => $model->npa_id]), ['class' => 'btn btn-info view-files', 'target' => 'blank']),['class' => 'col-md-3'])
        //echo Html::a('Просмотр прикрепленных файлов', Url::to(['/npa/files', 'id' => $model->npa_id]), ['class' => 'btn btn-info view-files', 'target' => 'blank']);
//        echo $form->field($model, 'file')->fileInput([
//            'multiple' => false,
//            'class' => 'btn btn-default btn-block',
//        ])->label('Постановление вместе с приложениями (одним файлом)');
        echo Html::tag('div', $form->field($model, 'file')->fileInput([
            'multiple' => false,
            'class' => 'btn btn-default btn-block',
        ])->label('Прикрепить постановление вместе с приложениями (одним файлом)'), ['class' => 'col-md-9']);
    }
    ?>
    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить документ' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

