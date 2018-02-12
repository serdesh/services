<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Division */

$this->title = 'Добавление подразделения';
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
