<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Division;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Подтверждаете удаление ' . $model->fio . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            //'created_at',
            [
                'attribute' => 'created_at',
                'value' => date('d.m.Y г.', $model->created_at),
            ],
            //'updated_at',
            //'role',
            [
                'attribute' => 'role',
                'value' => Role::findOne(['role_id' => $model->role])->role_name,
            ],
            'fio',
            //'division_id',
            [
                'attribute' => 'division_id',
                'value' => function ($data) {
                    return Division::findOne(['div_id' => $data->division_id])->div_name;
                }
            ],
            [
                'attribute' => 'password',
                'value' => Yii::$app->getSecurity()->decryptByPassword(Yii::$app->user->identity->password_hash, Yii::$app->user->identity->password_reset_token),
                //value' => Yii::$app->user->identity->password_reset_token,
            ]
    ],
    ]) ?>

</div>
