<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%seller}}".
 *
 * @property string $sel_id
 * @property string $sel_name
 * @property string $sel_phone
 */
class Seller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seller}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sel_name'], 'required'],
            [['sel_name'], 'string', 'max' => 128],
            [['sel_phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sel_id' => 'Код',
            'sel_name' => 'Наименование',
            'sel_phone' => 'Телефон',
        ];
    }
    
    public static function getSellers() {
        return ArrayHelper::map(Seller::find()->all(),'sel_id','sel_name');
        
    }
}
