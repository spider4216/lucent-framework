<?php
namespace core\modules\users\models;

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
            'username' => _("Username"),
            'password' => _("Password"),
            'password_again' => _("Repeat password again"),
            'email' => _("E-mail"),
            'roles' => _("Role"),
            'hash' => _("Hash"),
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
        ];
    }

//    public function beforeSave()
//    {
//        $this->role_id = 2;
//        return true;
//    }
}