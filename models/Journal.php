<?php

namespace app\models;

use Yii;
//use yii\base\Model;
use yii\db\ActiveRecord;
//use yii\db\Connection;

class Journal extends ActiveRecord
{
    /**
     * @return mixed
     */
    public static function getDb(){
        return Yii::$app->get('dbJournal');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tablemail}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'NUM_MAIL' => 'Входящий номер',
            'KOD_MAIL' => 'Номер по номенклатуре',
            'DAT_MAIL' => 'Дата регистрации',
            'FROM_MAIL' => 'От кого',
            'NUM_SENDER_MAIL' => 'Номер отправителя',
            'DAT_SENDER_MAIL' => 'Дата отправителя',
            'NAME_INFO_MAIL' => 'Заголовок информации',
            'EXECUTOR_MAIL' => 'Исполнители',
            'SROK' => 'Срок исполнения',
        ];
    }

}