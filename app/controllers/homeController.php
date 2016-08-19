<?php

namespace app\controllers;

use core\classes\SysView;
use core\classes\SystemController;
use core\system\Psr4AutoloaderClass;

/**
 * Class homeController
 * @package controllers
 * @author farZa
 *
 * Actions: action<Name> (camelCase)
 * Controllers: <Name>Controller (camelCase)
 */
class homeController extends SystemController
{
	public function actionIndex()
	{
		$psr4 = new Psr4AutoloaderClass();
		$psr4->register();
		$psr4->addNamespace('core\\system\\', 'core/system');

		SysView::render('index');
	}
}