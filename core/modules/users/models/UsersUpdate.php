<?php
namespace core\modules\users\models;

use core\classes\SysModel;

class UsersUpdate extends SysModel
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