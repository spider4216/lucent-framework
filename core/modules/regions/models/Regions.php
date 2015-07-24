<?php

namespace core\modules\regions\models;

use core\classes\SysModel;

class Regions extends SysModel
{
    protected static $table = 'regions';

    protected static function labels()
    {
        return [
            'name' => 'Наименование',
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'unique', 'script' => ['create']]],
            ['name' => ['required', 'unique', 'script' => ['update']]],
        ];
    }
}