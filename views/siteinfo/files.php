<?php

//use yii\grid\GridView;
//use yii\widgets\Pjax;
//use app\models\Siteinfo;
use app\models\User;
use yii\helpers\Html;

//use yii\helpers\FileHelper;
//use yii\helpers\Url;

$count = 0;
$zippedcount = 0;
$num = 0;
$zipPath = "uploads/temp";
$sourcepath = $model->si_path_attach;
$destFilepath = $zipPath . '/' . $model->si_id;

$this->title = 'Файлы к материалу: ' . $model->si_name_info;
$this->params['breadcrumbs'][] = ['label' => 'Информация для сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->si_name_info, 'url' => ['view', 'id' => $model->si_id]];
$this->params['breadcrumbs'][] = 'Файлы';
?>

<div class="container siteinfo-files">
    <h1><?= Html::encode($this->title) ?></h1>

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
            $num = 0;
            if (is_dir($sourcepath)) {
                $files = scandir($sourcepath);
                foreach ($files as $file) {
                    $fullpath = $sourcepath . '/' . $file;
                    if (is_file($fullpath) == TRUE) {
                        $num += 1;
                        echo '<tr>';
                        echo '<td>' . $num . '</td>';
                        echo '<td>';
                        echo Html::a($file, $fullpath);
                        echo '</td>';
                        echo '<td>' . round(filesize($fullpath) / 1024) . ' Кб</td>';
                        echo '<td class="status">';
                        if (User::isAdmin()) {
                            if (isset($result)) {
                                if ($result == TRUE) {
                                    echo '<span class="msg-ok">Готово!</span><br>';
                                } elseif ($result == FALSE) {
                                    echo '<span class="msg-error">Ошибка!</span><br>';
                                }
                            }
                        }
                    }
                }
            } else {
                //\yii\helpers\VarDumper::dump($sourcepath);
                if (is_file($sourcepath)) {
                    $file = basename($sourcepath);
                    $num += 1;
                    echo '<tr>';
                    echo '<td>' . $num . '</td>';
                    echo '<td>';
                    echo Html::a($file, $sourcepath);
                    echo '</td>';
                    echo '<td>' . round(filesize($sourcepath) / 1024) . ' Кб</td>';
                    echo '<td class="status">';
                    if (User::isAdmin()) {
                        if (isset($result)) {
                            if ($result == TRUE) {
                                echo '<span class="msg-ok">Готово!</span><br>';
                            } elseif ($result == FALSE) {
                                echo '<span class="msg-error">Ошибка!</span><br>';
                            }
                        }
                    }
                }
            }
            require '_ftpmodal.php';
            echo '</td>';
            echo '</tr>';
            ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($num > 0) {
                echo Html::a('Скачать все', ['siteinfo/zipdirectory', 'id' => $model->si_id, 'sourceDir' => $sourcepath, 'destDir' => $zipPath], ['class' => 'btn btn-lg btn-primary btn-block']);
            }
            //yii\helpers\VarDumper::dump($model);
            ?>
        </div>

    </div>
</div>
