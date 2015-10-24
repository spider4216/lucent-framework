<?php

namespace core\modules\blocks\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class Blocks extends SysModel
{
    protected static $table = 'blocks';

    protected static function labels()
    {
        return [
            'machine_name' => SysLocale::t("Machine name"),
            'name' => SysLocale::t("Block name"),
            'region_id' => SysLocale::t("Region"),
            'content' => SysLocale::t("Content"),
            'weight' => SysLocale::t("Weight"),
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required']],
            ['content' => ['required']],
            ['machine_name' => ['required', 'unique', 'machine_name']],
        ];
    }
}