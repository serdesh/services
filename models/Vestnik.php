<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use ZipArchive;

/**
 * This is the model class for table "{{%vestnik}}".
 *
 * @property string $vest_id
 * @property string $vest_number
 * @property string $vest_numberlitera
 * @property string $vest_pathfile
 * @property string $vest_data
 */
class Vestnik extends ActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vestnik}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vest_number', 'vest_stat'], 'integer'],
            [['vest_pathfile'], 'required'],
            [['vest_data'], 'safe'],
            [['vest_fullnumber'], 'string', 'max' => 10],
            [['vest_numberlitera'], 'string', 'max' => 10],
            [['vest_pathfile'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vest_id' => 'Код',
            'vest_number' => 'Номер',
            'vest_numberlitera' => 'Доп. номер',
            'vest_fullnumber' => 'Номер',
            'vest_pathfile' => 'Путь к файлу',
            'vest_data' => 'Дата',
            'vest_stat' => 'Статус размещения'
        ];
    }

    /**
     * @param $sourceFile Файл для архивации
     * @param $destfile Архивированный файл
     * @param $filename Имя файла
     */
    public static function zipFile($sourceFile, $destfile, $filename)
    {
        $zip = new ZipArchive();
        if (!$zip->open($destfile, ZIPARCHIVE::CREATE)) {
            exit("Не могу открыть " . $destfile . '<br>');
        }
        $zip->addFile($sourceFile->tempName, $filename);
        $zip->close();
        unset($zip);
    }

    /**
     * @param $model
     * @return string
     */
    public static function setNewPath($model)
    {
        $old_path = $model->vest_pathfile;
//        $filename = substr($old_path, strrpos($old_path, '/') + 1);
        $dir_path = substr($old_path, 0, strrpos($old_path, '/') + 1);
        $newpath = $dir_path . 'Vestnik' . $model->vest_fullnumber . '_' . date('Y', strtotime($model->vest_data)) . '.zip';
        if ($old_path && $newpath) {
            rename($old_path, $newpath);
        }

        return $newpath;
    }

    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->vest_numberlitera) {
            $this->vest_fullnumber = $this->vest_number . '-' . $this->vest_numberlitera;
        } else {
            $this->vest_fullnumber = $this->vest_number;
        }
        $model = new Siteinfo();

        $model->si_user_id = app()->user->id;
        $model->si_division_id = app()->user->identity->division_id;
        $model->si_data = date('Y-m-d H:i');
        $model->si_name_info = 'Вестник Шарьинского района №' . $this->vest_fullnumber . ' от ' . date('d.m.Yг.', strtotime($this->vest_data));
        $model->si_map_id = '16';
        $model->si_end_public = $model->si_data;
        $model->si_path_attach = $this->vest_pathfile;
        $model->save();
        return true;
    }

}
