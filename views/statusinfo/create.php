<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Statusinfo */

$this->title = 'Create Statusinfo';
$this->params['breadcrumbs'][] = ['label' => 'Statusinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statusinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
