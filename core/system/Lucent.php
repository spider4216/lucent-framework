<?php
namespace core\system;

use core\classes\SysApp;
use core\classes\SysComponent;
use core\components\RouteComponent;

class Lucent
{
	private static $app;
	//Default controller
	public static $defaultController = 'home';
	//Default action
	public static $defaultAction = 'index';
	//Namespace controller
	public static $defaultNamespace = 'app\\controllers\\';

	//Current Controller
	public static $currentController;
	//Current Action
	public static $currentAction;


	/*
	 * @author farZa
	 * @throws \ErrorException
	 * Запуск приложения
	 */
	public static function run()
	{
		header('Content-Type: text/html; charset=utf-8');
		self::init();

		$controller = self::$app->components->route->getController();
		$action = self::$app->components->route->getAction();

		$controller->$action();
	}

	private static function init()
	{
		self::$app = new SysApp();
		self::$app->components = new SysComponent();
		self::$app->components->route = new RouteComponent();
	}

}