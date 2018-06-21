<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //                    'filterModel' => $searchModel,
        'class' => 'index-table',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'ID_MAIL',
            [
                    'attribute' => 'NUM_MAIL',
                'value' => function($data){
                    return $data->NUM_MAIL . '/' . $data->KOD_MAIL;
                }
            ],
            'DAT_MAIL:date',
            'FROM_MAIL',
            'NUM_SENDER_MAIL',
            'DAT_SENDER_MAIL:date',
//            'NAME_INFO_MAIL',
            'EXECUTOR_MAIL',
            'SROK:date',
            'ISPOLNENO'
            //'username',

        ],
    ]); ?>

    <code><?= __FILE__ ?></code>
</div>
