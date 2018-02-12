<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?php //echo Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'fio',
            [
                'attribute' => 'division_id',
                'label' => 'Подразделение',
                'value' => function ($data) {
                    return \app\models\Division::findOne(['div_id' => $data->division_id])->div_name;
                }
            ],
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            // 'status',
            //'created_at',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d.m.Y г.', $data->created_at);
                },
            ],
            // 'updated_at',
            //'role',
            [
                'attribute' => 'role',
                'value' => function ($data) {
                    return Role::findOne(['role_id' => $data->role])->role_name;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
