<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Oldsiteinfo */

$this->title = 'Create Oldsiteinfo';
$this->params['breadcrumbs'][] = ['label' => 'Oldsiteinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oldsiteinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
