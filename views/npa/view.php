<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Npatype;
use app\models\User;
use app\models\Division;

/* @var $this yii\web\View */
/* @var $model app\models\Npa */
/* @var $model app\models\User */
/* @var $model app\models\Division */

$typedoc = Npatype::findOne(['ntype_id' => $model->npa_type_id])->ntype_name;

$this->title = $typedoc . ' №' . $model->npa_fullnumber . ' от ' . date('d.m.Y года.', strtotime($model->npa_date_adoption));
$this->params['breadcrumbs'][] = ['label' => 'Документы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="npa-view">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->npa_id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Удалить', ['delete', 'id' => $model->npa_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Действительно удлаить ' . $this->title . '?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'npa_id',
                //'npa_number',
                //'npa_literanumber',
                'npa_fullnumber',
                [
                    'attribute' => 'npa_date_adoption',
                    'value' => date('d.m.Y', strtotime($model->npa_date_adoption))
                ],
                [
                    'attribute' => 'npa_date_start',
                    'value' => date('d.m.Y', strtotime($model->npa_date_start))
                ],
                [
                    'attribute' => 'npa_sign_user_id',
                    'value' => User::getShortname(User::get_fio_by_userid($model->npa_sign_user_id)),
                ],
                //'npa_vestnik_id',
                [
                    'attribute' => 'npa_div_id',
                    'value' => Division::findOne(['div_id' => $model->npa_div_id])->div_name,
                    'label' => 'Подразделение ответственное за подготовку',
                ],
                //'npa_user_id',
                [
                    'attribute' => 'npa_path',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (file_exists($data->npa_path)) {
                            return Html::a(basename($data->npa_path), $data->npa_path);
                        } else {
                            return '<div class="alert alert-danger" role="alert">Файл не найден!</div>';
                        }
                    },
                    //'value' => yii\helpers\VarDumper::dump(file_exists($model->npa_path)),
                    'label' => 'Файл',
                ],
                'npa_title:ntext',
                'npa_text:ntext',
            ],
        ])
        ?>
    </div>
</div>
