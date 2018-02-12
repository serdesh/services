<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Siteinfo;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use app\models\Npa;


$zipPath = "D:/nasait";
//$path = 'uploads/siteinfo';
$sourcefile = $model->npa_path;
$this->title = Npa::get_typename($model->npa_type_id) . ' №' . $model->npa_fullnumber . ' от ' . date('d.m.Y', strtotime($model->npa_date_adoption));
$this->params['breadcrumbs'][] = ['label' => 'Документы администрации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->npa_id]];
$this->params['breadcrumbs'][] = 'Файлы';
?>

<div class="container siteinfo-files">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
//    $files = scandir($path);
//    foreach ($files as $file) {
//        if (is_file($path . '/' . $file) == TRUE) {
//            $filelist[] = $file;
//        }
//    }
//    \yii\helpers\VarDumper::dump($filelist);
//    $filelist = FileHelper::findFiles($path);
//    \yii\helpers\VarDumper::dump($filelist);
    ?>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя файла</th>
                <th>Размер</th>
                <th>...</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (file_exists($sourcefile)) {
                        echo '<tr>';
                        echo '<td>1</td>';
                        echo '<td>';
                        echo Html::a(basename($sourcefile), $sourcefile);
                        echo '</td>';
                        echo '<td>' . round(filesize($sourcefile) / 1024) . ' Кб</td>';
                        echo '<td>';
                        //echo 'Сжать';
                        echo '</td>';
                        echo '</tr>';
                    }
                
            
            ?>
        </tbody>
    </table>
    <div class="pull-left">
        <?php Pjax::begin(); ?>
        <?php //echo Html::a('Копировать файлы (Путь: ' . $destFilepath . ')', ['siteinfo/copyfiles', 'id' => $model->si_id, 'sourceDir' => $sourcedir, 'destDir' => $destFilepath], ['class' => 'btn btn-lg btn-primary']); ?>
        <?php
        if ($count > 0) {
            echo '<script>alert("Скопировано файлов: ' . $count . '")</script>';
        }
        if ($zippedcount > 0) {
            echo '<script>alert("Заархивировано файлов: ' . $zippedcount . '")</script>';
        }
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
