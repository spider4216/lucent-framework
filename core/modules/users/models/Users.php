<?php
namespace core\modules\users\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class Users extends SysModel
{
    public static $table = 'users';

    public function additionalFields()
    {
        return [
            'password_again' => '',
        ];
    }

    public static function labels()
    {
        return [
            'username' => SysLocale::t("Username"),
            'password' => SysLocale::t("Password"),
            'password_again' => SysLocale::t("Repeat password again"),
            'email' => SysLocale::t("E-mail"),
            'roles' => SysLocale::t("Role"),
            'hash' => SysLocale::t("Hash"),
        ];
    }

    public static function rules()
    {
        return [
            ['username' => ['required', 'username', 'unique', 'script' => ['update']]],
            ['email' => ['required', 'email', 'unique', 'script' => ['update']]],
            ['password' => ['required', 'script' => ['update']]],

            ['username' => ['required', 'username', 'unique', 'script' => ['create']]],
            ['password' => ['required', 'compare', 'script' => ['create']]],
            ['password_again' => ['comparedPassword', 'script' => ['create']]],
            ['email' => ['required', 'email', 'unique', 'script' => ['create']]],

            ['hash' => ['required', 'script' => ['signin']]],

            ['username' => ['required', 'username', 'unique', 'script' => ['vkAuth']]],
            ['email' => ['required', 'email', 'unique', 'script' => ['vkAuth']]],
            ['password' => ['required', 'script' => ['vkAuth']]],
        ];
    }
}