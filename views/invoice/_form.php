<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
//use app\models\Product;
//use app\models\Zakaz;
use app\models\Division;
use app\models\Seller;
use yii\grid\GridView;
use app\models\InvoiceSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Счет-фактура</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'inv_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'inv_data')->Input('date') ?>
        </div>
        <div class="col-md-7">
            <?=
            $form->field($model, 'inv_seller_id')->dropDownList(Seller::getSellers(), [
                'prompt' => 'Выберите продавца',
            ])->label('Продавец');
            ?>
        </div>
    </div>
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3>Товары</h3>    
                </div>
            </div>
            <div class="col-md-6">
                <?php echo $form->field($pmodel, 'prod_name')->textInput(); ?>
            </div>
            <div class="col-md-1">
                <?php echo $form->field($zmodel, 'zak_price')->textInput(); ?>
            </div>
            <div class="col-md-1">
                <?php echo $form->field($zmodel, 'zak_count')->textInput(); ?>
            </div>
            <div class="col-md-3">
                <?php
                $items = Division::getDivisions();
                echo $form->field($pmodel, 'prod_div_id')->dropDownList($items, ['prompt' => 'Выберите подразделение'])->label('Подразделение');
                ?>
            </div>
            <div class="col-md-1">
                <h3>
                    <?php
                    echo Html::a('+', Url::toRoute(['create', 'model' => $model]), ['class' => 'btn btn-success ad-line-invoice']);
                    ?>
                </h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $searchModel = new InvoiceSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'inv_number',
                            'inv_id'
                        ],
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
