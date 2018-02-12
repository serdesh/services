<?php

namespace app\models;

use yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $fio;
    public $division_id;

    public function rules() { //// Эти правила будут использоваться при валидации: формы ввода, с помощью вызова метода validate(), при попытки сохранения в таблицу БД
        return [
            [['username', 'fio', 'email'], 'trim'], //обрезает пробелы и превращает в NULL если ничего не останется
            [['fio', 'password', 'password_repeat'], 'required'], //Обязательное поле
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Имя пользователя уже используется!'], //'username' в модели \app\models\User(то есть в таблице tbl_user
            ['username', 'string', 'min' => 2, 'max' => 30],
//            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Адрес электронной почты уже используется!'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
            //['password_repeat', 'string', 'min' => 6],
            ['fio', 'string', 'max' => 100],
            ['fio', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Вы уже зарегистрированы!'],
            ['division_id', 'integer'],
            ['division_id', 'required', 'message' => 'Выберите одно из значений поля "Подразделение"'],
            
        ];
    }

    public function attributeLabels() { //Используется для локализации
        return [
            'username' => 'Имя пользователя',
            //'email' => 'Электронная почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'fio' => 'Фамилия Имя Отчетство',
            'division_id' => 'Код подразделения'
        ];
    }

    public function signup() { //Регистрация
        if (!$this->validate()) { //если валидация вернула false то возвращаем NULL
            return null;
        }
        $user = new User(); //Используем ActiveRecord User
        //$user->username = $this->username;
        $user->username = $this->getUsername($this->fio);
        //$user->email = $this->email;
        $user->email = $this->getEmail($user->username);
        $user->setPassword($this->password);
        $user->generatePasswordResetToken();
        $user->generateAuthKey();
        $user->created_at = time();
        $user->fio = $this->fio;
        $user->division_id = $this->division_id;
        return $user->save() ? $user : null; //Сохраняем свойства в таблицу tbl_user если переменная не равна NULL
    }

    public static function getUsername($fio) { //Получаем имя пользователя Петров Иван Сергеевич = petrov_is
        $fio = (string) $fio;
        $fio = strip_tags($fio);
        $fio = str_replace(['\n', '\r'], ' ', $fio);
        $fio = preg_replace('/\s+/', ' ', $fio); //Удаляем повторяющиеся пробелы
        $fio = trim($fio); // убираем пробелы в начале и конце строки
        $fio = function_exists('mb_strtolower') ? mb_strtolower($fio) : strtolower($fio); // переводим строку в нижний регистр (иногда надо задать локаль)
        $fio = strtr($fio, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        $fio = preg_replace("/[^0-9a-z-_ ]/i", "", $fio); // очищаем строку от недопустимых символов
        //Разбиваем на Фамилию имя и отчество
        $arr_fio = explode(" ", $fio);
        $arr_fio[1] = substr($arr_fio[1], 0, 1); //Получаем первую букву имени
        $arr_fio[2] = substr($arr_fio[2], 0, 1); //Первую букву отчества
//        foreach ($arr_fio as $key => $value) {
//            
//        } 
        return $arr_fio[0] . '_' .$arr_fio[1] . $arr_fio[2]; // возвращаем результат        
    }
    
    Public static function getEmail($username) {
      $arrUsername = explode("_", $username);
      $letterName = substr($arrUsername[1], 0, 1);
      return $letterName . '.' . $arrUsername[0] . '@admshmr.ru';
    }

}
