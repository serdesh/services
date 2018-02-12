<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%statusinfo}}".
 *
 * @property string $stat_id
 * @property string $stat_name
 */
class Statusinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statusinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stat_name'], 'required'],
            [['stat_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'stat_id' => 'Stat ID',
            'stat_name' => 'Stat Name',
        ];
    }
    
    public function getStatusImage($statId) {
        if ($statId == '1') {
            //Ожидание публикации
            $img = Html::button('', [
                        'class' => 'btn btn-warning glyphicon glyphicon-hourglass',
                        'onclick' => 'change_permission(); false;',
                        'data-toggle' => 'tooltip',
                        'title' => 'Ожидает публикации',
            ]);
        } elseif ($statId == '2') {
            //Опубликовано
            $img = Html::button('', [
                        'class' => 'btn btn-success glyphicon glyphicon-ok',
                        'onclick' => 'change_permission(); false;',
                        'data-toggle' => 'tooltip',
                        'title' => 'Опубликовано',
            ]);
        } elseif ($statId == '3') {
            //Отказано
            $img = Html::button('', [
                        'class' => 'btn btn-danger glyphicon glyphicon-remove',
                        'onclick' => 'change_permission(); false;',
                        'data-toggle' => 'tooltip',
                        'title' => 'Отказано в публикации',
            ]);
        } else {
            $img = Statusinfo::findOne(['stat_id' => $data->si_status])->stat_name;
        }
        return $img;
    }
}
