<?php

use app\models\Siteinfo;
use app\models\Oldsiteinfo;
use app\models\Olddivision;
use app\models\Division;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Статистика предоставления информации на сайт';
$this->params['breadcrumbs'][] = $this->title;
$data = Yii::$app->request->post();
$startdata = '';
$start_data = '';
$end_data = '';
if ($data) {
    $start_data = $data['Stat']['start_data'];
    $end_data = $data['Stat']['end_data'];
}

if ($start_data) {
    $startdata = date('d.m.Y', strtotime($start_data));
} else {
    $startdata = date('d.m.Y', strtotime("last Monday"));
}
$enddata = date('d.m.Y', strtotime($end_data . '+1 day'));
$enddata_head = date('d.m.Y', strtotime($end_data . '+0 day'));

$lastMonday = Date('d.m.Y', strtotime('last Monday'));
$divisions = Siteinfo::findBySql('SELECT DISTINCT(si_division_id) FROM tbl_siteinfo WHERE si_data >= STR_TO_DATE("' . $startdata . '", "%d.%m.%Y") AND si_data <= STR_TO_DATE("' . $enddata . '", "%d.%m.%Y")')->all(); // AND si_data < STR_TO_DATE("' . $enddata . '", "%d.%m.%Y")
//echo \yii\helpers\VarDumper::dump($enddata_head);
?>

<div class="container-fluid center-block">
    <div class="row">

        <div style="height: 40px; float: right; cursor: hand;">
            <span class="noprint"><svg height="30" width="30" onclick="print()"><path d="M4,2h8v2h1V1H3v3h1M0,5v6h3v1l3,3h7v-4h3V5m-3,2v1H12v6H6V12H4V8H3V7m2,1h6v1H5m0,1h6v1H5"></path></svg></span>
        </div>
    </div>
    <div class="row">
        <h3 class="text-center">Обобщенная информация<br>о предоставленных материалах на сайт администрации Шарьинского района<br>в период с '<?= $startdata ?>' по '<?= $enddata_head ?>'<br><small>по состоянию на <?= Date('Hчас. iмин. d.m.Y') ?></small></h3>
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <tr><th class="text-center">Подразделение</th><th class="text-center">Наименование материала</th><th class="text-center">Дата отправки</th></tr>
                <?php
                foreach ($divisions as $key => $value) {
                    $divid = $value['si_division_id'];
                    $userID = $value['si_user_id'];
                    $divname = Division::findOne(['div_id' => $divid])->div_name;


                    //Получаем инфу подразделения за период
                    $info = Siteinfo::findBySql('SELECT si_name_info, si_user_id, si_data FROM tbl_siteinfo WHERE si_division_id = ' . $divid . ' AND si_data >= STR_TO_DATE("' . $startdata . '", "%d.%m.%Y") AND si_data <= STR_TO_DATE("' . $enddata . '", "%d.%m.%Y")')->all();
                    echo '<tr>';
                    if (count($info) >= 2) {
                        echo '<td rowspan="' . count($info) . '">';
                    } else {
                        echo '<td>';
                    }

                    echo $divname . '<br><span class="label label-success">' . count($info) . 'шт.</span>';
                    echo '</td>';
                    //Добавляем наименования информаций
                    foreach ($info as $key => $value) {
                        echo '<td>';
                        echo $value->si_name_info;
                        echo '</td>';
                        echo '<td>';
                        echo '<span class="label label-info">' . date('d.m.Y', strtotime($value->si_data)) . '</span>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div class="row" id="po-godam">
        <h1 class="text-center">Количество предоставленной информации, по годам</h1>
        <h3 class="text-center">период с '<?= Date('d.m', strtotime($startdata)) ?>' по '<?= substr($enddata_head, 0, strlen($enddata) - 5) ?>'</h3>
        <div class="col-md-12">
            <table class="table table-hover table-bordered">
                <tr><th>Подразделение</th><th>2017</th><th>2016</th><th>2015</th><th>2014</th></tr>
                <?php
                foreach ($divisions as $key => $value) {
                    $divid = $value['si_division_id'];

                    $divname = Division::findOne(['div_id' => $divid])->div_name;
                    //Количество инфы за период 2017 года
                    $count2017 = Siteinfo::findBySql('SELECT * FROM tbl_siteinfo WHERE si_division_id = ' . $divid . ' AND si_data >= STR_TO_DATE("' . $startdata . '", "%d.%m.%Y") AND si_data <= STR_TO_DATE("' . $enddata . '", "%d.%m.%Y")')->all();
                    //Получем ID для подразделения старой базы
                    if ($divname){
                        $oldID = Olddivision::getIdByDivisionName($divname);
                    }
                    
                    if ($oldID) {
                        //Получаем инфу подразделения за период 2016

                        $sdate2016 = substr($startdata, 0, strlen($startdata) - 1) . 6;
                        $edate2016 = substr($enddata, 0, strlen($enddata) - 1) . 6;

                        $count2016 = Oldsiteinfo::findBySql('SELECT * FROM tbl_oldsiteinfo WHERE KONTORA_ID = ' . $oldID . ' AND DATA >= STR_TO_DATE("' . $sdate2016 . '", "%d.%m.%Y") AND DATA <= STR_TO_DATE("' . $edate2016 . '", "%d.%m.%Y")')->all();

                        //Получаем инфу подразделения за период 2015

                        $sdate2015 = substr($startdata, 0, strlen($startdata) - 1) . 5;
                        $edate2015 = substr($enddata, 0, strlen($enddata) - 1) . 5;

                        $count2015 = Oldsiteinfo::findBySql('SELECT * FROM tbl_oldsiteinfo WHERE KONTORA_ID = ' . $oldID . ' AND DATA >= STR_TO_DATE("' . $sdate2015 . '", "%d.%m.%Y") AND DATA <= STR_TO_DATE("' . $edate2015 . '", "%d.%m.%Y")')->all();

                        //Получаем инфу подразделения за период 2015

                        $sdate2014 = substr($startdata, 0, strlen($startdata) - 1) . 4;
                        $edate2014 = substr($enddata, 0, strlen($enddata) - 1) . 4;

                        $count2014 = Oldsiteinfo::findBySql('SELECT * FROM tbl_oldsiteinfo WHERE KONTORA_ID = ' . $oldID . ' AND DATA >= STR_TO_DATE("' . $sdate2014 . '", "%d.%m.%Y") AND DATA <= STR_TO_DATE("' . $edate2014 . '", "%d.%m.%Y")')->all();
                        echo '<tr>';
                        echo '<td>' . $divname . '</td>';
                        //Добавляем кол-во информаций
                        echo '<td>' . count($count2017) . '</td>';
                        echo '<td>' . count($count2016) . '</td>';
                        echo '<td>' . count($count2015) . '</td>';
                        echo '<td>' . count($count2014) . '</td>';
                        echo '</tr>';
                        //\yii\helpers\VarDumper::dump($count2017);
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <?php Pjax::begin() ?>
    <?php
    $form = ActiveForm::begin([
                'id' => 'stat-form',
                'action' => Url::to(['site/stat']),
    ]);
    ?>
    <div class="row noprint">
        <div class="col-md-2 col-md-offset-4">
            <?= $form->field($model, 'start_data')->input('date')->label('Начало периода') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'end_data')->input('date')->label('Конец периода') ?>
        </div>
    </div>
    <div class="row noprint">
        <div class="form-group col-md-4 col-md-offset-4">
            <?=
            Html::submitButton('Показать', [
                'class' => 'btn btn-success btn-block btn-lg'])
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
