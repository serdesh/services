<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оборудование';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid invoice-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
        <div class="col-md-2">
            <h1>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success btn-block btn-lg']) ?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'inv_id',
                    'inv_number',
                    'inv_data',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
