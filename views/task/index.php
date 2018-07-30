<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$taskStatus = app()->getRequest()->get('status');

if ($taskStatus == Task::TASK_DONE){
    $this->title = 'Исполненные задачи';
} else {
    $this->title = 'Текущие задачи';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <!--TaskNavbar-->
    <nav class="navbar navbar-default navbar-fixed" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="brand" href="#"><h1><?= $this->title ?></h1></a>
            </div>
            <div class="buttons">
                <ul class="nav pull-right">
                    <li><?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success', 'id' => 'btn-createtask']) ?></li>
                </ul>
            </div>
        </div>
    </nav>    
    <!--End TaskNavbar-->

    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif;?>

    <?php Pjax::begin(); ?>

    <div class="task-index">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['id' => 'urg-' . $model['task_urgency']]; //Указываем ID строки = значению важности (task_urgency) для раскраски
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'task_description:ntext:Описание',
                
                [
                    'attribute' => 'task_user',
                    'value' => function ($data) {
                        return \app\models\User::findOne(['id' => $data->task_user])->fio;
                    }
                ],
                
                [
                    'attribute' => 'task_data',
                    'value' => function ($data) {
                        return date('d.m.Y H:i', strtotime($data->task_data));
                    }
                ],
                'task_notes:ntext',
                'task_solution:ntext',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    </div>
    <?php Pjax::end(); ?>
</div>