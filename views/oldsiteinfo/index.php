<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OldsiteinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oldsiteinfos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oldsiteinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Oldsiteinfo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KONTORA_ID',
            'DATA',
            'NAME_INFO:ntext',
            'RAZDEL:ntext',
            // 'IP:ntext',
            // 'NAME_COMP:ntext',
            // 'TEXT_INFO:ntext',
            // 'END_PUBLIC_DATE',
            // 'PATH_ATTACH:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
