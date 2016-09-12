<?php
namespace core\system;

use Packages\PHPDAO\DAOFactory;
use core\classes\SysApp;
use core\classes\SysComponent;
use core\components\ConfigComponent;
use core\components\DAOComponent;
use core\components\InfoComponent;
use core\components\RouteComponent;

class Lucent
{
	public static $app;

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
		self::$app->components->info = new InfoComponent();
		self::$app->components->route = new RouteComponent();
		self::$app->components->config = new ConfigComponent();
		self::$app->components->dao = new DAOComponent();

		self::$app->components->config->setConfig('main');
		// todo Нужно брать генератор и ДАО объект из конфига
		self::$app->db = self::$app->components->dao->createGenerator(DAOFactory::MYSQL)->getDaoObject('generalDAO');

	}

}