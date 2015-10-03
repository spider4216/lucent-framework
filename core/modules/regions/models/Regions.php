<?php

namespace core\modules\regions\models;

use core\classes\SysModel;
use core\modules\blocks\models\Blocks;
use core\modules\menu\models\Menu;

class Regions extends SysModel
{
    protected static $table = 'regions';

    protected static function labels()
    {
        return [
            'name' => _("Name"),
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

        $blocks = Blocks::findAll(['region_id = :id', [':id' => $regionID->id]], [], ['weight' => 'ASC']);

		$menus = Menu::findAll(['region_id = :id', [':id' => $regionID->id]], [], ['weight' => 'ASC']);

		$allBlocks = [];
		foreach ($blocks as $block) {
			$allBlocks[$block->weight][] = $block;
		}

		foreach ($menus as $menu) {
			$allBlocks[$menu->weight][] = $menu;
		}

		ksort($allBlocks);

        return $allBlocks;
    }
}