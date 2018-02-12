<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Division */

$this->title = $model->div_name;
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->div_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->div_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'div_id',
            'div_name',
            
            [
                'attribute' => 'div_boss',
                'label' => 'Руководитель',
                'value' => User::findOne(['id' => $model->div_boss])->fio,
            ],
            'div_note:ntext',
        ],
    ]) ?>

</div>
