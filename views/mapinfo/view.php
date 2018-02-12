<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mapinfo */

$this->title = $model->mi_name;
$this->params['breadcrumbs'][] = ['label' => 'Разделы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapinfo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->mi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->mi_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Подтверждаете удаление раздела ' . $model->mi_name . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mi_id',
            'mi_name',
            'mi_parent_id',
            'mi_url:ntext',
            'mi_add_permission',
        ],
    ]) ?>

</div>
