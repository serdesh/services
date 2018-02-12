<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ftpaccounts}}".
 *
 * @property int $ftp_id
 * @property string $ftp_login
 * @property string $ftp_pass
 * @property string $ftp_path Путь к которому имеет доступ аккаунт
 */
class Ftpaccounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ftpaccounts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ftp_login', 'ftp_pass'], 'required'],
            [['ftp_login', 'ftp_pass'], 'string', 'max' => 50],
            [['ftp_path', 'ftp_site'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ftp_id' => 'Код',
            'ftp_login' => 'Логин',
            'ftp_pass' => 'Пароль',
            'ftp_path' => 'Путь',
            'ftp_site' => 'Сайт',
        ];
    }
}
