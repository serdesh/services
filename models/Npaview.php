<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%npaview}}".
 *
 * @property string $nview_id
 * @property string $nview_name
 */
class Npaview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%npaview}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nview_name'], 'required'],
            [['nview_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nview_id' => 'Nview ID',
            'nview_name' => 'Nview Name',
        ];
    }
}
