<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%division}}".
 *
 * @property string $div_id
 * @property string $div_name
 * @property string $div_note
 */
class Division extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%division}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['div_name'], 'required'],
            [['div_note'], 'string'],
            [['div_name'], 'string', 'max' => 150],
            [['div_name'], 'unique'],
            [['div_boss'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'div_id' => 'Код подразделения',
            'div_name' => 'Наименование',
            'div_boss' => 'Руководитель',
            'div_note' => 'Примечание',
        ];
    }

    public static function getDivisions() { //Возвращает список подразделений списком
        return ArrayHelper::map(Division::find()->all(), 'div_id', 'div_name');
    }

}
