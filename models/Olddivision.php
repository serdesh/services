<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%olddivision}}".
 *
 * @property integer $ID
 * @property string $NAME
 * @property string $NOTES
 */
class Olddivision extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%olddivision}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['NAME'], 'required'],
            [['NAME', 'NOTES'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'NAME' => 'Name',
            'NOTES' => 'Notes',
        ];
    }

    public static function getIdByDivisionName($name) {
        if ($name) {
            $query = Olddivision::findOne(['NAME' => $name]);
            if ($query){
                return $query->ID;
            }
            //return Olddivision::findOne(['NAME' => $name])->ID;
        }
    }

}
