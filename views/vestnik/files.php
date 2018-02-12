<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Siteinfo;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\helpers\Url;


$sourcepath = $model->vest_pathfile;
$this->title = 'Вестник №' . $model->vest_fullnumber . ' от ' . $model->vest_data;
$this->params['breadcrumbs'][] = ['label' => 'Вестник шарьинского района', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
            if ($sourcepath) {
                $files = scandir($sourcepath);
                $num = 0;
                foreach ($files as $file) {
                    $fullpath = $sourcepath . '/' . $file;
                    if (is_file($fullpath) == TRUE) {
                        $num += 1;
                        echo '<tr>';
                        echo '<td>' . $num . '</td>';
                        echo '<td>';
                        echo $file;
                        echo '</td>';
                        echo '<td>' . round(filesize($fullpath) / 1024) . ' Кб</td>';
                        echo '<td>';
                        echo 'Скачать';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
    <div class="pull-left">
        <?php Pjax::begin(); ?>
        <?= Html::a('Архивировать (Путь: ' . $zipPath . ')', ['siteinfo/zipdirectory', 'id' => $model->si_id, 'sourceDir' => $sourcepath, 'destDir' => $zipPath], ['class' => 'btn btn-lg btn-primary']); ?>
        <?= Html::a('Копировать файлы (Путь: ' . $destFilepath . ')', ['siteinfo/copyfiles', 'id' => $model->si_id, 'sourceDir' => $sourcepath, 'destDir' => $destFilepath], ['class' => 'btn btn-lg btn-primary']); ?>
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
