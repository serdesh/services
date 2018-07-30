<?php

namespace app\models;

use Yii;

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii2mod\ftp\FtpClient;

/**
 * This is the model class for table "{{%siteinfo}}".
 *
 * @property string $si_id
 * @property string $si_user_id
 * @property string $si_division_id
 * @property string $si_data
 * @property string $si_name_info
 * @property string $si_map_id
 * @property string $si_text
 * @property string $si_end_public
 * @property string $si_path_attach
 */
class Siteinfo extends ActiveRecord
{

    /**
     * @var array $Files Файлы, прикрепленные к материалу
     * @var int $ftp_id ID поля в таблице ftp аккаунтов
     * @var string $selectedfile Выбранный для загрузки файл
     * @var string $desiredname имя файла - указанное пользователем
     * @var string $ftp_pass ФТП пароль
     */
    public $Files;
    public $ftp_id;
    public $selectedfile;
    public $desiredname;
    public $ftp_pass;

    /**
     * @inheritdoc
     */
    public static function tableName()
{
    return '{{%siteinfo}}';
}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['si_name_info'], 'required'],
            [['si_user_id', 'si_division_id', 'si_map_id', 'si_status', 'ftp_id'], 'integer'],
            [['si_data', 'si_end_public'], 'safe'],
            [['si_text', 'si_path_attach', 'selectedfile', 'desiredname'], 'string'],
            [['si_name_info'], 'string', 'max' => 500],
            [['Files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 15, 'message' => 'Нельзя загрузить больше 15 файлов.'], //'extensions' => 'png, jpg, jpeg, gif, doc, docx, rtf, txt, xls, xlsx, 7zip, zip, odt, ods, pdf',
            [['si_map_id'], 'required', 'message' => 'Необходимо выбрать раздел'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'si_id' => 'Код',
            'si_user_id' => 'Код пользователя',
            'si_division_id' => 'Код подразделения',
            'si_data' => 'Дата',
            'si_name_info' => 'Наименование информации',
            'si_map_id' => 'Код раздела',
            'si_text' => 'Текст информации',
            'si_end_public' => 'Дата завершения публикации (не обязательно)',
            'si_path_attach' => 'Путь ко вложениям',
            'si_status' => 'Статус',
            'Files' => 'Вложения',
            'ftp_id' => 'FTP код',
            'selectedfile' => 'Выбранный файл',
            'desiredname' => 'Отправить как... (Требуемое имя на сервере, с расширением)',
        ];
    }

    static function isAuthor($infoID)
    {
        $authorID = static::findOne(['si_id' => $infoID])->si_user_id;
        if ($authorID != Yii::$app->user->identity->id) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    static function getNameInfo($infoId)
    {
        return static::findOne(['si_id' => $infoId])->si_name_info;
    }

    public function getEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'si_user_id']);
    }

    public function getSection()
    {
        return $this->hasOne(Mapinfo::className(), ['mi_id' => 'si_map_id']);
    }

    public function getDivisions()
    {
        return $this->hasOne(Division::className(), ['div_id' => 'si_division_id']);
    }

    /**
     * Получаем ссылку на файл или список ссылок на файлы, в зависимости от передаваемого пути (путь к файлу или путь к папке)
     * @param $path
     * @return string
     */
    public static function getListFiles($path)
    {
        if (is_file($path)) {
            $filename = basename($path);
            return Html::a($filename, $path);
        } else {
            $sourcepath = $path;
            //$list = '';
            if (isset($sourcepath) && is_dir($sourcepath)) {
                $files = scandir($sourcepath);
                $list = '<ul>';
                foreach ($files as $file) {
                    $fullpath = $sourcepath . '/' . $file;
                    if (is_file($fullpath) == TRUE) {
                        $list = $list . '<li>';
                        $list = $list . Html::a($file, $fullpath);
                        $list = $list . '</li>';
                    }
                }
                $list = $list . '</ul>';
                return $list;
            } else {
                return '<b>Файлы не найдены</b>';
            }
        }
    }

    /**
     * Получает список файлов
     * @param $path
     * @return array
     */
    public static function getFilesInArray($path)
    {
//        $list = [];
        if (is_file($path)) {
            $list[] = $path;
        } elseif (is_dir($path)) {
            $list = FileHelper::findFiles($path);
        } else {
            $list[] = '';
        }
        return $list;
    }


    /**
     * @param $dir
     */
    public static function removeDirectory($dir)
    {
        self::removeFiles($dir);
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    public static function removeFiles($dir) {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                is_dir($obj) ? self::removeDirectory($obj) : unlink($obj);
            }
        }
    }

    /**
     * Send a file via FTP
     * @var $model
     * @var $ftp  \yii2mod\ftp\FtpClient()
     * @return bool
     * @throws \yii2mod\ftp\FtpException
     */
    public static function sendFtp($model)
    {
        $files = self::getFilesInArray($model->si_path_attach);

        $ftp = new FtpClient();

        if ($model->desiredname) {
            $fileName = $model->desiredname;
        } else {
            $fileName = basename($files[$model->selectedfile]);
        }

        $localPath = $files[$model->selectedfile]; //Путь к локальному файлу
        $query = Ftpaccounts::findOne(['ftp_id' => $model->ftp_id]);
        $ftpLogin = $query->ftp_login;
        $ftpPass = $query->ftp_pass;
        $host = $query->ftp_site;

        if ($ftp->connect($host, false, 21, 60)) {
            if ($ftp->login($ftpLogin, $ftpPass)) {
                $ftp->pasv(true);
                $ftp->put($fileName, $localPath, FTP_BINARY);
                if ($ftp->size($fileName) == filesize($localPath)) {
                    return true;
                }
            }
        }
        return false;
    }
}
