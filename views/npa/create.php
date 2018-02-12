<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Npa */

$this->title = 'Добавление документа';
$this->params['breadcrumbs'][] = ['label' => 'Документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="npa-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>
    </div>
</div>
