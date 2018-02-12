<?php

namespace app\models;

use Yii;
use ZipArchive;

/**
 * This is the model class for table "{{%npa}}".
 *
 * @property string $npa_id
 * @property string $npa_number
 * @property string $npa_literanumber
 * @property string $npa_date_adoption
 * @property string $npa_date_start
 * @property string $npa_sign_user_id
 * @property string $npa_vestnik_id
 * @property string $npa_div_id
 * @property string $npa_user_id
 * @property string $npa_path
 * @property string $npa_title
 * @property string $npa_text
 */
class Npa extends \yii\db\ActiveRecord {

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%npa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['npa_number', 'npa_sign_user_id', 'npa_vestnik_id', 'npa_div_id', 'npa_user_id', 'npa_view_id', 'npa_type_id'], 'integer'],
            [['npa_date_adoption', 'npa_date_start'], 'safe'],
            [['npa_number', 'npa_path', 'npa_title', 'npa_text'], 'required'],
            [['npa_title', 'npa_text'], 'string'],
            [['npa_literanumber'], 'string', 'max' => 10],
            [['npa_fullnumber'], 'string', 'max' => 20],
            [['npa_path'], 'string', 'max' => 300],
            [['npa_number'], 'unique', 'targetAttribute' => ['npa_type_id','npa_number', 'npa_literanumber', 'npa_date_adoption'], 'message' => 'Такой документ уже есть в базе!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'npa_id' => 'Код',
            'npa_number' => 'Основной номер',
            'npa_literanumber' => 'Доп. номер',
            'npa_fullnumber' => 'Номер',
            'npa_date_adoption' => 'Дата',
            'npa_date_start' => 'Дата начала действия',
            'npa_sign_user_id' => 'Кем подписан документ',
            'npa_vestnik_id' => 'Код вестника',
            'npa_div_id' => 'Код подразделения, ответсвенного за подготовку',
            'npa_user_id' => 'Код служащего, разместившего документ',
            'npa_path' => 'Путь к файлу',
            'npa_title' => 'Заголовок документа',
            'npa_text' => 'Текст документа',
            'npa_view_id' => 'Вид документа',
            'npa_type_id' => 'Тип документа',
        ];
    }

    public static function zipfile($sourceFile, $destfile, $filename) {
        $zip = new ZipArchive();
        if (!$zip->open($destfile, ZIPARCHIVE::CREATE)) {
            exit("Не могу открыть " . $destfile . '<br>');
        }
        $zip->addFile($sourceFile->tempName, $filename);
        $zip->close();
        unset($zip);
    }

    public static function get_trans_typename($model) {
        switch (Npatype::findOne(['ntype_id' => $model->npa_type_id])->ntype_name) {
            case 'Постановление':
                return 'Post';
            case 'Распоряжение':
                return 'Rasp';
            case 'Решение':
                return 'Resh';
            case 'Приказ':
                return 'Prikaz';
        }
    }

    public static function get_typename($id) {
        return Npatype::findOne(['ntype_id' => $id])->ntype_name;
    }

    public static function get_viewname($id) {
        return Npaview::findOne(['nview_id' => $id])->nview_name;
    }

    public static function isAutor($model) {
        if ($model->npa_user_id == Yii::$app->user->identity->id) {
            return true;
        } else {
            return false;
        }
    }

}
