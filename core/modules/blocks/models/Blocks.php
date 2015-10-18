<?php

namespace core\modules\blocks\models;

use core\classes\SysModel;

class Blocks extends SysModel
{
    protected static $table = 'blocks';

    protected static function labels()
    {
        return [
            'machine_name' => _("Machine name"),
            'name' => _("Block name"),
            'region_id' => _("Region"),
            'content' => _("Content"),
            'weight' => _("Weight"),
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