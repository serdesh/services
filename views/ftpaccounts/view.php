<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ftpaccounts */

$this->title = $model->ftp_id;
$this->params['breadcrumbs'][] = ['label' => 'Ftpaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ftpaccounts-view">

    <h1><?= Html::encode($this->title);?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ftp_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ftp_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ftp_id',
            'ftp_login',
            'ftp_pass',
            'ftp_site',
            'ftp_path',
        ],
    ]) ?>

</div>
