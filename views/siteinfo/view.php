<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;
use app\models\Division;
use app\models\Mapinfo;
//use app\models\Statusinfo;
use app\models\Siteinfo;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Siteinfo */


$this->title = $model->si_name_info;
$this->params['breadcrumbs'][] = ['label' => 'Информация для сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class=" container siteinfo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="btn-group">
        <?php
        if (User::isAdmin()) {
            echo Html::a('Изменить', ['update', 'id' => $model->si_id], ['class' => 'btn btn-primary']);
            Modal::begin([
                'header' => '<h2>Отправка файла по FTP</h2>',
                'toggleButton' => [
                    'label' => 'Отправить по фтп',
                    'class' => 'btn btn-info'
                ],
//            'footer' => 'Desh@2018  '
            ]);

            include_once '_ftpmodal.php';
            Modal::end();
        }
        ?>

        <?php
        if (Siteinfo::isAuthor($model->si_id) or User::isAdmin()) {
            echo Html::a('Удалить', ['delete', 'id' => $model->si_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Подтверждаете удаление ' . $this->title . '?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </div>
    <?php
    $dir = Yii::$app->params['siteinfo_fs'] . '/' . $model->si_path_attach;
    $dir2 = $model->si_path_attach;
    $diff = date_diff(date_create($model->si_end_public), date_create($model->si_data));
    if ($diff->format('%d%') > 0) {
        $endPublic = date('d.m.Y г.', strtotime($model->si_end_public));
    } else {
        $endPublic = 'Не указана';
    }
    $division = Division::findOne(['div_id' => $model->si_division_id])->div_name;
    ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'si_id',
            [
                'attribute' => 'si_user_id',
                'value' => User::findOne(['id' => $model->si_user_id])->fio,
                'label' => 'Пользовтель'
            ],
            [
                'attribute' => 'si_division_id',
                'label' => 'Подразделение',
                'value' => function ($data) {
                    return Division::findOne(['div_id' => $data->si_division_id])->div_name;
                },
            ],
            [
                'attribute' => 'si_data',
                'value' => date('d.m.Y г. H:i', strtotime($model->si_data)),
            ],
            'si_name_info',
            [
                'attribute' => 'si_map_id',
                'value' => Mapinfo::getFullpathcategory($model->si_map_id),
            ],
            'si_text:ntext',
            [
                'attribute' => 'si_end_public',
                'value' => $endPublic,
            ],
            [
                'attribute' => 'si_path_attach',
                'format' => 'raw',
                'value' => $dir,
            ],
            [
                'attribute' => 'Files',
                'format' => 'raw',
                'value' => Siteinfo::getListFiles($model->si_path_attach),
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Статус',
                'value' => function ($data) {
                    //$statclass = '';
                    if ($data->si_status == 1) {
                        $statclass = 'btn-warning glyphicon glyphicon-hourglass';
                    } elseif ($data->si_status == 2) {
                        $statclass = 'btn-success glyphicon glyphicon-ok';
                    } else {
                        $statclass = 'btn-danger glyphicon glyphicon-remove';
                    }
                    return Html::a('', Url::toRoute(['/siteinfo/setstatus', 'id' => $data->si_id]), [
                        'class' => 'btn ' . $statclass,
                        'data-toggle' => 'tooltip',
                        'title' => 'Ожидает публикации',
                        'id' => 'btn-waitpublish-' . $data->si_id,
                    ]);
                },
            ],
        ],
    ])
    ?>
    <?php
    if (isset($result)) {
        \yii\helpers\VarDumper::dump($result,1, true);
    }
    ?>

</div>
