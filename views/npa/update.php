<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use app\models\Npa;
use app\models\User;


/* @var $this yii\web\View */
/* @var $model app\models\Npa */

$this->title = Npa::get_typename($model->npa_type_id) . ' №' . $model->npa_fullnumber . ' от ' . date('d.m.Y года', strtotime($model->npa_date_adoption));
$this->params['breadcrumbs'][] = ['label' => 'Документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->npa_id]];
$this->params['breadcrumbs'][] = 'Внесение изменений';
?>
<div class="npa-update">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php
        if (Npa::isAutor($model->npa_id) or User::isAdmin()) {
            echo $this->render('_form', ['model' => $model]);
        } else {
            throw new ForbiddenHttpException('Изменение невозможно. Доступ запрещен');
        }
        
        ?>
    </div>
</div>
