<?php

namespace core\modules\regions\models;

use core\classes\SysModel;
use core\modules\blocks\models\Blocks;
use core\modules\menu\models\Menu;
use core\modules\page\models\Page;
use core\modules\page\models\PageCollections;

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

		$collections = PageCollections::findAll(['region_id = :id', [':id' => $regionID->id]], [], ['weight' => 'ASC']);

		$allBlocks = [];
		foreach ($blocks as $block) {
			$allBlocks[$block->weight][] = $block;
		}

		foreach ($menus as $menu) {
			$allBlocks[$menu->weight][] = $menu;
		}

		foreach ($collections as $collection) {

			$allBlocks[$collection->weight][] = $collection;
		}

		ksort($allBlocks);

		$allStdBlocks = [];
		foreach ($allBlocks as $blocks) {
			foreach ($blocks as $block) {
				if ($block instanceof Blocks) {
					$allStdBlocks['content_block'][] = [
						'id' => $block->id,
						'title' => $block->name,
						'content' => $block->content,
					];
				}

				if ($block instanceof Menu) {
					$nestedSet = new \core\extensions\ExtNestedset($block->machine_name);
					$data = $nestedSet->findAllNodes();

					$allStdBlocks['menu_block'][] = [
						'id' => $block->id,
						'title' => $block->name,
						'content' => $data,
					];
				}

				if ($block instanceof PageCollections) {
					$collections = Page::findAll(['page_type_id = :id', [':id' => $block->page_type_id]]);

					if (!empty($collections)) {
						$setPages = [];
						foreach ($collections as $page) {
							$setPages[] = [
								'title' => $page->title,
								'content' => $page->content,
								'id' => $page->id,
							];
						}

						$allStdBlocks['collection_block'][] = [
							'id' => $block->id,
							'content' => $setPages
						];
					}
				}
			}

		}

        return $allStdBlocks;
    }
}