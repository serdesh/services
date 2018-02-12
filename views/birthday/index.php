<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BirthdaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Birthdays';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="birthday-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить именинника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'b_id',
            'b_fio:ntext',
            'b_datbirth',
            'b_tel:ntext',
            'b_yearbirth',
            // 'b_notes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
