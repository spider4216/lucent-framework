<?php
namespace core\modules\users\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class Roles extends SysModel
{
    public static $table = 'roles';

    public static function labels()
    {
        return [
            'name' => SysLocale::t("Role name"),
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'unique']],
        ];
    }

}