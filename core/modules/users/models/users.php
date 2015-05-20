<?php
namespace core\modules\users\models;

use core\classes\cmodel;


class Users extends Cmodel
{
    public static $table = 'users';

    public $password_again;

    public static function labels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'password_again' => 'Повторите пароль',
            'email' => 'Электронная почта',
            'roles' => 'Роль',
        ];
    }

    public static function rules()
    {
        return [
            'username' => ['required','username'],
            'password' => ['required', 'compare'],
            'password_again' => ['compared'],
            'email' => ['required', 'email'],
        ];
    }

    public function beforeSave()
    {
        $this->role_id = 2;
        return true;
    }
}