<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%organ}}".
 *
 * @property string $organ_id
 * @property string $organ_name
 * @property string $organ_inn
 */
class Organ extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organ}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organ_name'], 'required'],
            [['organ_inn'], 'integer'],
            [['organ_name'], 'string', 'max' => 255],
            [['organ_name'], 'unique'],
            [['organ_inn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organ_id' => 'Код органа',
            'organ_name' => 'Наименование органа',
            'organ_inn' => 'ИНН органа',
        ];
    }
}
