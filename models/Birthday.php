<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "{{%birthday}}".
 *
 * @property integer $b_id
 * @property string $b_fio
 * @property integer $b_datbirth
 * @property string $b_tel
 * @property integer $b_yearbirth
 * @property string $b_notes
 */
class Birthday extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%birthday}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['b_fio', 'b_datbirth'], 'required'],
            [['b_fio', 'b_tel', 'b_notes'], 'string'],
            [['b_datbirth', 'b_yearbirth'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'b_id' => 'Код',
            'b_fio' => 'Ф.И.О.',
            'b_datbirth' => 'Месяц/день рождения',
            'b_tel' => 'Телефон',
            'b_yearbirth' => 'Год рождения',
            'b_notes' => 'Примечание',
        ];
    }
    
    Public static function getBirthdaymans() {
        $date = date('nd');
        //\yii\helpers\VarDumper::dump($date);
        return Birthday::findAll(['b_datbirth' => $date]);
    }
    
    Public static function getNormalizeDate($month_day, $year = '') {
        $months = [
            '1' => 'января',
            '2' => 'февраля',
            '3' => 'марта',
            '4' => 'апреля',
            '5' => 'мая',
            '6' => 'июня',
            '7' => 'июля',
            '8' => 'августа',
            '9' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
            
        ];
        //формат $month_day 5 февраля = 205 (месяц без нуля и число с нулём)
        $day = substr($month_day, -2);
        $num_month = substr($month_day, 0, -2);
        $month = $months[$num_month];
        if ($year){
            return $day . ' ' . $month . ' ' . $year . 'г.';
        } else {
            return $day . ' ' . $month;
        }
        
        
    }
    
}
