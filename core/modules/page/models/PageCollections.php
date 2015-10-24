<?php

namespace core\modules\page\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class PageCollections extends SysModel
{
	protected static $table = 'page_collections';

	protected static function labels()
	{
		return [
			'name' => SysLocale::t("Name"),
			'description' => SysLocale::t("Description"),
			'page_type_id' => SysLocale::t("Page type"),
			'pagination' => SysLocale::t("Pagination"),
			'region_id' => SysLocale::t("Regions"),
			'links' => SysLocale::t("Links"),
			'weight' => SysLocale::t("Weight"),
		];
	}

	public static function rules()
	{
		return [
			['name' => ['required']],
			['page_type_id' => ['required', 'numeric']],
			['region_id' => ['required', 'numeric']],
		];
	}
}