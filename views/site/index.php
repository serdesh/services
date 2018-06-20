<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;
use app\models\Siteinfo;
use app\models\Birthday;
use yii\grid\GridView;

$this->title = 'Сервисы администрации ШМР';

if (User::isAdmin()) {
    $countNotPublish = Siteinfo::find()->where(['si_status' => '1'])->count();
    if ($countNotPublish > 0) {
        $countInfo = '<span class="label label-danger">' . $countNotPublish . '</span>';
    } else {
        $countInfo = '<span class="label label-success">0</span>';
    }
} else {
    $countInfo = '';
}
?>
<div class="site-index">
    <div class="body-content">
        <div class="container">
            <div class="row" id="plashki">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <div class="pull-left">
                                <a href="<?= Url::to(['/siteinfo/index']) ?>"><?= Html::img('/img/info512.png', ['alt' => 'Инфо для сайта', 'width' => 40]) ?></a>
                            </div>
                            <a href="<?= Url::to(['/siteinfo/index']) ?>"><h4>Информация для
                                    сайта <?= $countInfo; ?></h4></a>
                        </div>
                        <div class="panel-body text-center">
                            <p>Инструмент отправки информации для последующего размещения на сайте администрации
                                Шарьинского района.</p>
                            <a href="<?= Url::to(['/site/stat']) ?>"><span class="glyphicon glyphicon-stats"></span>
                                Статистика отправки информации</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <div class="pull-left">
                                <a href="<?= Url::to(['/npa/index']) ?>"><?= Html::img('/img/document512.png', ['alt' => 'База НПА', 'width' => 40]) ?></a>
                            </div>
                            <a href="<?= Url::to(['/npa/index']) ?>"><h4>База документов администрации</h4></a>
                        </div>
                        <div class="panel-body">
                            <p class="text-center"><br>База внутренних документов администрации Шарьинского
                                муниципального района</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <div class="pull-left">
                                <a href="<?= Url::to(['/birthday/index']) ?>"><?= Html::img('/img/cookie4406.png', ['alt' => 'Дни рождения', 'width' => 40]) ?></a>
                            </div>
                            <h4>Дни рождения<br>служащих</h4>
                        </div>
                        <div class="panel-body">
                            <?php
                            //Именинники
                            $mans = Birthday::getBirthdaymans();
                            //yii\helpers\VarDumper::dump($mans);
                            if ($mans) {
                                echo '<div style="height:60px;" class="text-right">';
                                echo Html::img('/img/hbsmile.png', ['alt' => 'День рождения!', 'width' => 60, 'class' => 'pull-left', 'style' => 'padding-right:10px;']);

                                echo '<h4>День рождения сегодня:</h4>';
                                echo '</div>';
                                echo '<div>';
                                echo '<ul class="birthday-list">';
                                foreach ($mans as $value) {
                                    if ($value->b_notes) {
                                        $value->b_notes = ' (' . $value->b_notes . ')';
                                    }
                                    //yii\helpers\VarDumper::dump($value);
                                    echo '<li class="text-right">';
                                    echo $value->b_fio . $value->b_notes . '<br><small>Д.р. ' . Birthday::getNormalizeDate($value->b_datbirth, $value->b_yearbirth) . '</small>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                                echo '</div>';
                            } else {
                                echo Html::img('/img/hbgrsmile.png', ['alt' => 'Некого поздравлять', 'width' => 60, 'class' => 'pull-left', 'style' => 'padding-right:10px;']);
                                echo '<h4>Сегодня именинников нет</h4>';
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row" id="plashki">

                <?php

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel,
                    'class' => 'index-table',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'username',

                    ],
                ]);
                ?>

                <!--                <div class="col-sm-12 col-md-12 col-lg-12">-->
                <!--                    <a href="/uploads/programm/SpravkiBKsetup_ver._2.4.1.msi">-->
                <!--                        <h1>Скачать программное обеспечение "Справки БК" (версия 2.4.1)</h1>-->
                <!--                    </a>-->
                <!--                    <h1><small>Подготовка справок о доходах, расходах, об имуществе и обязательствах имущественного характера</small></h1>-->
                <!--                    <hr> -->
                <!--                </div>-->
                <!--            </div>      -->
                <!--            <div class="row">-->
                <!--                <div class="col-sm-6 col-md-6 col-lg-6">-->
                <!--                    <a href="/uploads/programm/instr_BK.doc"><h3>Инструкция по работе с программным обеспечением "Справки БК"</h3></a>-->
                <!--                </div>-->
                <!--                <div class="col-sm-6 col-md-6 col-lg-6 helbtn">-->
                <!--                    --><?php //require '_modal_install_spravkabk.php'; ?>
                <!--                </div>-->
            </div>
        </div>
    </div>
</div>
