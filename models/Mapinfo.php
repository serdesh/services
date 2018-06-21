<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%map_info}}".
 *
 * @property string $mi_id
 * @property string $mi_name
 * @property string $mi_parent_id
 * @property string $mi_url
 * @property integer $mi_add_permission
 */
class Mapinfo extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%mapinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['mi_name'], 'required'],
            [['mi_parent_id', 'mi_add_permission'], 'integer'],
            //[['mi_add_permission'], 'integer', 'value' => 1],
//            ['mi_add_permission', function ($attribute, $params)
//		{
//			if($this->$attribute == 0) $this->addError($attribute, 'В данном разделе размещение информации невзможно.');
//		}],
            [['mi_url'], 'string'],
            [['mi_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'mi_id' => 'Код',
            'mi_name' => 'Наименование',
            'mi_parent_id' => 'Код родителя',
            'mi_url' => 'Url',
            'mi_add_permission' => 'Разрешено размещать',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getList() {
        $data = static::find()
                ->select(['mi_id', 'mi_parent_id', 'mi_name'])
                ->orderBy('mi_name ASC')
                ->asArray()
                ->all();

        $sort = new SortList([
            'data' => $data,
            'prefix' => '-',
        ]);
        $sortList = ArrayHelper::map($sort->getList(), 'mi_id', 'mi_name');
        return $sortList;
    }

    /**
     * @inheritdoc
     */
    public static function getFullpathcategory($id) {
        $path ='';
        while ($id != 0) {
            $info = Mapinfo::find()
                    ->select(['mi_name', 'mi_parent_id'])
                    ->where(['mi_id' => $id])
                    ->asArray()
                    ->one();
            $razdel[] = $info['mi_name'];
            $id = $info['mi_parent_id'];
        }
        
        if (!isset($razdel)) {
            return '';
        }
        
        foreach (array_reverse($razdel) as $item) {
            $path = $path . $item . '/';
        }
        return $path;
    }

}

class SortList extends \yii\db\ActiveRecord {

    public $data;
    public $prefix = '   ';

    protected function getPath($category_id, $prefix = false) {
        foreach ($this->data as $item) {
            if ($category_id == $item['mi_id']) {
                $prefix = $prefix ? $this->prefix . $prefix : $item['mi_name'];
                if ($item['mi_parent_id']) {
                    return $this->getPath($item['mi_parent_id'], $prefix);
                } else {
                    return $prefix;
                }
            }
        }
        return '';
    }

    public function getList($parent_id = 0) {
        $data = [];

        foreach ($this->data as $item) {
            if ($parent_id == $item['mi_parent_id']) {
                $data[] = [
                    'mi_id' => $item['mi_id'],
                    'mi_name' => $this->getPath($item['mi_id'])
                ];
                $data = array_merge($data, $this->getList($item['mi_id']));
            }
        }
        return $data;
    }
    
    Public static function get_category_permissions($id){
        return Mapinfo::findOne(['mi_id' => $id])->mi_add_permission;
    }

}
