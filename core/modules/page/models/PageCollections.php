<?php

namespace core\modules\page\models;

use core\classes\SysModel;

class PageCollections extends SysModel
{
	protected static $table = 'page_collections';

	protected static function labels()
	{
		return [
			'name' => _("Name"),
			'description' => _("Description"),
			'page_type_id' => _("Page type"),
			'pagination' => _("Pagination"),
			'region_id' => _("Regions"),
			'links' => _("Links"),
			'weight' => _("Weight"),
		];
	}

	public static function rules()
	{
		return [
			['name' => ['required']],
			['page_type_id' => ['required']],
			['region_id' => ['required']],
		];
	}
}