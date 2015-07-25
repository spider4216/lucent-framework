<?php

namespace core\modules\regions\models;

use core\classes\SysModel;
use core\modules\blocks\models\Blocks;

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

    /**
     * @param $name - имя региона
     * @return array|bool
     * Получить все блоки по имени региона
     */
    public static function getBlocks($name)
    {
        if (empty($name)) {
            return false;
        }

        $regionID = self::findByColumn('name', $name);

        if (empty($regionID)) {
            return false;
        }

        $blocks = Blocks::findAll(['region_id = :id', [':id' => $regionID->id]]);

        return $blocks;
    }
}