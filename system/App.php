<?php
namespace system;

class App
{
	//Default controller
	public static $defaultController = 'home';
	//Default action
	public static $defaultAction = 'index';
	//Namespace controller
	public static $defaultNamespace = 'controllers\\';

	//Current Controller
	public static $currentController;
	//Current Action
	public static $currentAction;

	public static function run()
	{
		header('Content-Type: text/html; charset=utf-8');
		self::route();
	}

	private static function route()
	{
		$url = $_SERVER['REQUEST_URI'];
		//path string
		$path = parse_url($url, PHP_URL_PATH);
		//explode it and get array
		$pathParts = explode('/', $path);

		$controller = !empty($pathParts[1]) ? $pathParts[1] : self::$defaultController;
		$action = !empty($pathParts[2]) ? $pathParts[2] : self::$defaultAction;

		self::$currentController = $controller;
		self::$currentAction = $action;

		$controller = self::$defaultNamespace . $controller . 'Controller';
		$action = 'action' . ucfirst($action);

		if (!class_exists($controller)) {
			throw new \ErrorException('Controller does not exist');
		}

		$objController = new $controller;

		if (!method_exists($objController, $action)) {
			throw new \ErrorException('action does not exist');
		}

		$objController->$action();
	}
}