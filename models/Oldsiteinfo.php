<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%oldsiteinfo}}".
 *
 * @property integer $ID
 * @property integer $KONTORA_ID
 * @property string $DATA
 * @property string $NAME_INFO
 * @property string $RAZDEL
 * @property string $IP
 * @property string $NAME_COMP
 * @property string $TEXT_INFO
 * @property string $END_PUBLIC_DATE
 * @property string $PATH_ATTACH
 */
class Oldsiteinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oldsiteinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KONTORA_ID'], 'integer'],
            [['DATA', 'NAME_INFO', 'RAZDEL'], 'required'],
            [['DATA', 'END_PUBLIC_DATE'], 'safe'],
            [['NAME_INFO', 'RAZDEL', 'IP', 'NAME_COMP', 'TEXT_INFO', 'PATH_ATTACH'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KONTORA_ID' => 'Kontora  ID',
            'DATA' => 'Data',
            'NAME_INFO' => 'Name  Info',
            'RAZDEL' => 'Razdel',
            'IP' => 'Ip',
            'NAME_COMP' => 'Name  Comp',
            'TEXT_INFO' => 'Text  Info',
            'END_PUBLIC_DATE' => 'End  Public  Date',
            'PATH_ATTACH' => 'Path  Attach',
        ];
    }
}
