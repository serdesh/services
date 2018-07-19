<?php

namespace app\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $task_id
 * @property string $task_description
 * @property string $task_notes
 * @property integer $task_user
 * @property integer $task_order
 * @property integer $task_urgency
 * @property string $task_data
 * @property integer $task_deleted
 * @property string $task_solution
 */
class Task extends ActiveRecord
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
            [['task_description', 'task_notes', 'task_solution'], 'string'],
            [['task_user', 'task_order', 'task_urgency', 'task_deleted'], 'integer'],
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
            'task_deleted' => 'Задача помечена на удаление',
            'task_solution' => 'Результат'
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
