<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%urgency}}".
 *
 * @property string $urg_id
 * @property string $urg_name
 * @property string $urg_description
 */
class Urgency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%urgency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['urg_name'], 'required'],
            [['urg_description'], 'string'],
            [['urg_name'], 'string', 'max' => 30],
            [['urg_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'urg_id' => 'Urg ID',
            'urg_name' => 'Urg Name',
            'urg_description' => 'Urg Description',
        ];
    }
}
