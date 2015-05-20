<?php
namespace core\modules\users\models;

use core\classes\cmodel;

class Roles extends Cmodel
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
            'name' => ['required'],
        ];
    }
}