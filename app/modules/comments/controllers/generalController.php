<?php

namespace app\modules\comments\controllers;

use core\classes\SysController;
use core\classes\SysView;

class generalController extends SysController
{
	public static function permission()
	{
		// "-" - неавторизованный пользователь
		return [
			'index' => ['user', '-'],
		];
	}

	public function breadcrumbs()
	{
		//% - замещение. Например Хочу передать виджету никий заголовок для принта
		return [
			'index' => [
				_("comments") => '-',
			],
		];
	}

	public function actionIndex()
	{
		static::$title = _("Comments");

		$view = new SysView();

		$view->display('index');
	}
}