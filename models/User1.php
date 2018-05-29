<?php

namespace app\models;

//use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User1 extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0; //Если пользователь заблокирован (удален)
    const STATUS_ACTIVE = 10; //Если пользователь активен
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

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
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public static function isUserAdmin($username) {
        //\yii\helpers\VarDumper::dump($username);
        if (static::findOne(['username' => $username, 'role' => 1])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
     public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'fio' => 'Ф.И.О',
            'email' => 'Эл. почта',
            'role' => 'Роль',
            'created_at' => 'Создан',
            'division_id' => 'Код подразделения'
        ];
    }

}
