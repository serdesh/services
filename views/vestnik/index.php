<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VestnikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вестник Шарьинского района';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container vestnik-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить вестник', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'vest_id',
            //'vest_number',
            //'vest_numberlitera',
            'vest_fullnumber',
            
            [
                'attribute' => 'vest_data',
                'value' => function ($data) {
                    return date('d.m.Y', strtotime($data->vest_data));
                }
            ],
            
            //'vest_pathfile',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
