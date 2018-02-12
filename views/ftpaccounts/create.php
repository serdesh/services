<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ftpaccounts */

$this->title = 'Create Ftpaccounts';
$this->params['breadcrumbs'][] = ['label' => 'Ftpaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container ftpaccounts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
