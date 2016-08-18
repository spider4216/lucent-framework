<?php

namespace app\controllers;

use core\system\CView;

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
		$psr4 = new \core\system\Psr4AutoloaderClass();
		$psr4->register();
		$psr4->addNamespace('core\\system\\', 'core/system');

		CView::render('index');
	}
}