<?php
namespace core\modules\users\models;

use core\classes\SysModel;

class Roles extends SysModel
{
    public static $table = 'roles';

    public static function labels()
    {
        return [
            'name' => 'Наименование роли',
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'unique']],
        ];
    }

}