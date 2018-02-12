<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Fias;

$this->title = 'Пример использования API ФИАС';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h1><?= Html::encode($this->title); ?> </h1>
    <div class="row">
        <div class="col-md-4">
            <?php
            //15784a67-8cea-425b-834a-6afe0e3ed61c Костромская область
            //a031240c-d73d-4c40-b839-fd880d6a777c Шарьинский район
            //http://basicdata.ru/api/json/fias/addrobj/a031240c-d73d-4c40-b839-fd880d6a777c/ - Населеные пункты ШМР
            //http://basicdata.ru/api/json/fias/addrobj/5c6b8394-8b66-4b4f-8bf6-9b256feb4a3a - Улицы Зебляков (AOGUID населенного пункта)
            //http://basicdata.ru/api/json/fias/house/e03e8c3b-1095-459c-8320-250d7b085c0a/ - Дома улицы Ветеранов (AOUGUID)
//            $content = file_get_contents('http://basicdata.ru/api/json/fias/addrobj/a031240c-d73d-4c40-b839-fd880d6a777c/');
//            $data = json_decode($content, true);
//            $np = $data['data'];
//            $items = array();
//            foreach ($np as $value) {
//                $name = $value['offname'];
//                if ($value['actstatus'] == '1') {
//                    $items[] = $value['shortname'] . '. ' . $value['offname'] . ' ОКАТО: ' . $value['okato'];
//                    $current_name = $name;
//                }
//            }
//
//            echo \yii\helpers\Html::dropDownList('Населенные пункты', '', $items, ['prompt' => 'выберите нп']);
//            echo '<br>';
//            $var_str = '5c6b8394-8b66-4b4f-8bf6-9b256feb4a3a';
//            $content_str = file_get_contents('http://basicdata.ru/api/json/fias/addrobj/' . $var_str . '/');
//            $dat_str = json_decode($content_str, true);
//            $streets = $dat_str['data'];
////
//            $var_house = 'ffd556b9-1eac-46e3-b7e8-110764482432';
//            $content_house = file_get_contents('http://basicdata.ru/api/json/fias/house/' . $var_house . '/');
//            $dat_houses = json_decode($content_house, true);
//            $houses = $dat_houses['data'];
//
//            echo \yii\helpers\VarDumper::dump($houses[0]) . '<br>';
//            echo \yii\helpers\VarDumper::dump($dat_str['data'][0]) . '<br>'; //Улицы
//            echo \yii\helpers\VarDumper::dump($np[119]); //Населенные пункты (119 - пос Зебляки)
            ?>
        </div>
    </div>
    <div class="container">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <?php $items = Fias::get_np(); //Получаем все населенные пункты района  ?> 
                <?php // echo \yii\helpers\VarDumper::dump($model) ?>
                <?php // echo \yii\helpers\VarDumper::dump($items); ?>
                <?=
                $form->field($model, 'aoguid_np')->DropDownList($items, [
                    'id' => 'np',
                    'prompt' => '-Выберите населённый пункт-',
                    'data-toggle' => 'dropdown',
                    'onchange' => '$.post("' . Url::toRoute('site/street-lists')
                    . '", {citycode: $(this).val()},'
                    . 'function(res){'
                    . '$("#street").html(res);'
                    . '$("#street").attr("disabled", false);'
                    . '$("#house").val(0);'
                    . '$("#house").attr("disabled", true);'
                    . '});',
                ])->label('Населённый пункт')
                ?>
            </div>
            <div class="col-md-4">
                <?=
                $form->field($model, 'aoguid_street')->DropDownList([], [
                    'id' => 'street',
                    'prompt' => '-Выберите улицу-',
                    'data-toggle' => 'dropdown',
                    'onchange' => '$.post("' . Url::toRoute('site/house-lists') . '", {streetcode: $(this).val()},'
                    . 'function(res){'
                    . '$("#house").html(res);'
                    . '$("#house").attr("disabled", false);'
                    . '});',
                ])->label('Улица')
                ?>
            </div>
            <div class="col-md-4">
                <?=
                $form->field($model, 'house')->dropDownList([], [
                    'id' => 'house',
                    'prompt' => '-Выберите дом-',
                    'data-toggle' => 'dropdown',
                ])->label('Дом')
                ?>
            </div>
        </div>
       
        <?php ActiveForm::end(); ?>
    </div>

</div>

