<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;
/**
 * This is the model class for table "{{%task}}".
 *
 * @property string $task_id
 * @property string $task_description
 * @property string $task_notes
 * @property string $task_user
 * @property string $task_order
 * @property string $task_urgency
 * @property string $task_data
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_description'], 'required'],
            [['task_description', 'task_notes'], 'string'],
            [['task_user', 'task_order', 'task_urgency'], 'integer'],
            [['task_data'], 'safe'],
            [['task_order'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Код задачи',
            'task_description' => 'Описание',
            'task_notes' => 'Примечание',
            'task_user' => 'Заявитель',
            'task_order' => 'Порядок',
            'task_urgency' => 'Важность',
            'task_data' => 'Дата',
        ];
    }
    
    public function getOrder($order) { //Возвращает first/last/other - Первый элемент/последний элемент/дугое для показа стрелок изменения позиции в таблице задач
        if ($order == 1){
            return 'first';
        } else {
            $lastOrder = Task::find()->max('task_order');
            //VarDumper::dump($lastOrder);
            if ($order == $lastOrder){
                return 'last';
            } else {
                return 'other';
            }
            
        }
    }
 }
