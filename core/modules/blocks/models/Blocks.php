<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 24.07.2015
 * Time: 22:08
 */

namespace core\modules\blocks\models;

use core\classes\SysModel;

class Blocks extends SysModel
{
    protected static $table = 'blocks';

    protected static function labels()
    {
        return [
            'name' => _("Block name"),
            'region_id' => _("Region"),
            'content' => _("Content"),
            'weight' => _("Weight"),
        ];
    }

    public static function rules()
    {
        return [
            ['name' => ['required', 'unique']],
            ['content' => ['required']],
        ];
    }
}