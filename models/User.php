<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $role
 * @property string $fio
 * @property string $division_id
 * @property string $openpass
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0; //Если пользователь заблокирован (удален)
    const STATUS_ACTIVE = 10; //Если пользователь активен
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    //Переопределяем методы для интерфейса

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" не реализован.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password) {
        $this->openpass = $password;
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @return bool
     */
    public static function isAdmin() {
        if (!Yii::$app->user->isGuest) {
            $loggedusername = Yii::$app->user->identity->username;
            if (static::findOne(['username' => $loggedusername, 'role' => 1])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public static function isUserAdmin() {
        if (!Yii::$app->user->isGuest) {
            $username = Yii::$app->user->identity;
            if ($username) {
                if (static::findOne(['username' => $username, 'role' => 1])) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
        return FALSE;
    }

    public static function getShortname($fio) {
        $arr_fio = explode(" ", $fio); //Разбиваем на Фамилию имя и отчество
        $arr_fio[1] = mb_substr($arr_fio[1], 0, 1); //Получаем первую букву имени
        $arr_fio[2] = mb_substr($arr_fio[2], 0, 1); //Первую букву отчества
        return $arr_fio[0] . htmlspecialchars_decode('&nbsp;') . $arr_fio[1] . '.' . $arr_fio[2] . '.';
    }

    public static function get_fio_by_userid($id) {
        return User::findOne(['id' => $id])->fio;
    }

    /**
     * @inheritdoc
     */
    //Если правила включены - не проходит регистрация, а если выключены - не редактируется пользователь
    public function rules() {
        return [
            //[['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['username', 'auth_key', 'password_hash', 'email', 'created_at'], 'required'],
            [['status', 'created_at', 'role', 'division_id'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email', 'openpass'], 'string', 'max' => 255],
            [['fio'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['fio'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Создан',
            'role' => 'Роль',
            'fio' => 'Ф.И.О.',
            'division_id' => 'Код подразделения',
            'openpass' => 'Пароль'
        ];
    }

    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

}
