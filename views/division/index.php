<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подразделения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать поразделение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'div_name:ntext',
            [
                'attribute' => 'div_boss',
                'value' => function ($data){
                    return app\models\User::findOne(['id' => $data->div_boss])->fio;
                }
            ],
            'div_note:ntext',
            'div_id',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
