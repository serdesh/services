<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Fias extends Model {

    public $aoguid_np; //AOGUID населенного ппункта
    public $aoguid_street;
    public $house;


    public function rules()
    {
        return [
            [['aoguid_np', 'aoguid_street', 'house'], 'string'],
        ];
    }
    
    public function attributeLabels() { //Используется для локализации
        return [
            'aoguid_np' => 'Код населенного пункта',
            'aoguid_street' => 'Код улицы',
    ];}
    
    public static function get_np() {
        $content = file_get_contents('http://basicdata.ru/api/json/fias/addrobj/a031240c-d73d-4c40-b839-fd880d6a777c/');
        $data = json_decode($content, true);
        $np = $data['data'];
        foreach ($np as $value) {
            if ($value['actstatus'] == '1') {
                $items[$value['aoguid']] = $value['shortname'] . '. ' . $value['offname'];
            }
        }
        return $items;
    }

}
