<?php
namespace core\modules\page\models;

use core\classes\SysModel;

class PageType extends SysModel
{
	protected static $table = 'page_types';

	protected static function labels()
	{
		return [
			'title' => _("Title"),
			'description' => _("Description"),
		];
	}

	public static function rules()
	{
		return [
			['title' => ['required']],
		];
	}
}