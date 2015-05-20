<?php
namespace core\modules\users\models;

use core\classes\cmodel;


class UsersUpdate extends Cmodel
{
    public static $table = 'users';

    public static function labels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Электронная почта',
            'roles' => 'Роль',
        ];
    }
}