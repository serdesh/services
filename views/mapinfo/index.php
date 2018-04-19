<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Mapinfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MapinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Карта сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapinfo-index container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Добавить раздел', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'mi_id',
            'mi_name',
            //'mi_parent_id',
            [
                'attribute' => 'me_parent_id',
                'label' => 'Родительский раздел',
                'value' => function($data) {
                    return Mapinfo::getFullpathcategory($data->mi_parent_id);
                }
            ],
            //'mi_url:text',
            [
                'attribute' => 'mi_url',
                'format' => 'raw',
                'value' => function ($data) {
                  return  Html::a($data->mi_url, $data->mi_url);
                },
            ],
            //'mi_add_permission',
            [
                'attribute' => 'mi_add_permission',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->mi_add_permission != '0') {
                        $img = Html::button('', [
                                    'class' => 'btn btn-success glyphicon glyphicon-ok',
                                    'onclick' => 'change_permission(); false;',
                        ]);
                    } else {
                        $img = Html::button('', [
                                    'class' => 'btn btn-danger glyphicon glyphicon-remove',
                                    'onclick' => 'change_permission(); false;'
                        ]);
                    }
                    return $img;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
