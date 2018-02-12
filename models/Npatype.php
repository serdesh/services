<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%npatype}}".
 *
 * @property string $ntype_id
 * @property string $ntype_name
 */
class Npatype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%npatype}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ntype_name'], 'required'],
            [['ntype_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ntype_id' => 'Ntype ID',
            'ntype_name' => 'Ntype Name',
        ];
    }
}
