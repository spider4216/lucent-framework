<?php

namespace core\components;

use core\classes\SysComponent;
use core\classes\SystemController;
use core\system\Lucent;

class RouteComponent
{
	protected $controller;

	protected $action;

	public function __construct()
	{
		Lucent::$app->components->info->defaultController = 'home';
		Lucent::$app->components->info->defaultAction = 'index';
		Lucent::$app->components->info->defaultNamespace = 'app\\controllers\\';

		$this->route();
	}

	/**
	 * @author farZa
	 * @throws \ErrorException
	 * Роутинг приложения
	 */
	protected function route()
	{
		$url = $_SERVER['REQUEST_URI'];
		//path string
		$path = parse_url($url, PHP_URL_PATH);
		//explode it and get array
		$pathParts = explode('/', $path);

		$controller = !empty($pathParts[1]) ? $pathParts[1] : Lucent::$app->components->info->defaultController;
		$action = !empty($pathParts[2]) ? $pathParts[2] : Lucent::$app->components->info->defaultAction;

		Lucent::$app->components->info->currentController = $controller;
		Lucent::$app->components->info->currentAction = $action;

		$controller = Lucent::$app->components->info->defaultNamespace . $controller . 'Controller';
		$action = 'action' . ucfirst($action);

		$psr4 = new \core\system\Psr4AutoloaderClass();
		$psr4->register();
		$psr4->addNamespace('app\\controllers\\', 'app/controllers');

		if (!class_exists($controller)) {
			throw new \ErrorException('Controller does not exist');
		}

		$objController = new $controller;

		if (!method_exists($objController, $action)) {
			throw new \ErrorException('action does not exist');
		}

		$this->controller = $objController;
		$this->action = $action;

		//$objController->$action();
	}

	public function getController():SystemController
	{
		return $this->controller;
	}

	public function getAction():string
	{
		return $this->action;
	}
}