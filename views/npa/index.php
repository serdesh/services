<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Npatype;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NpaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid npa-index">
    <div class="col-md-10 col-sm-12 text-center">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="col-md-2 col-sm-12 text-center">
        <h1>
            <?= Html::a('Добавить документ', ['create'], ['class' => 'btn btn-success']) ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php Pjax::begin(); ?>    
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'npa_type_id',
                        'value' => function ($data) {
                            return Npatype::findOne(['ntype_id' => $data->npa_type_id])->ntype_name;
                        },
                    ],
                    'npa_fullnumber',
                    [
                        'attribute' => 'npa_date_adoption',
                        'value' => function ($data) {
                            return date('d.m.Y', strtotime($data->npa_date_adoption));
                        },
                    ],
                    'npa_title:ntext',
                    [
                        'attribute' => 'npa_text',
                        'value' => function ($data) {
                            return mb_substr($data->npa_text, 0, 300, 'UTF-8') . '...';
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
