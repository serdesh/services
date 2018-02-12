<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Stat extends Model {

    public $division; //Подразделение
    public $name_info; //Наименование материала
    public $data_info;
    public $start_data;
    public $end_data;

    public function rules() {
        return [
            [['si_division_id', 'si_name_info'], 'string'],
            [['start_data', 'end_data', 'data_info'], 'date'],
        ];
    }

    public function attributeLabels() { //Используется для локализации
        return [
            'si_division_id' => 'Код подразделения',
            'si_name_info' => 'Наименование информации',
            'start_data' => 'Начало периода',
            'end_data' => 'Конец периода',
            'data_info' => 'Дата отправки'
        ];
    }


}
