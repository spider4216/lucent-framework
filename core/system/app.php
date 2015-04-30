<?php
namespace core\system;
use core\classes\Casset;

/**
 * Class App
 * @package app\core\system
 *
 * App - главный класс всего приложения.
 */
class App
{
    //Главный метод класса. Вся инициализация приложения проходит через этот метод.
    public static function run()
    {
        $config = include __DIR__ . '/../../app/config/main.php';
        Casset::filesAttach();
        static::semantic_url($config['default_controller'], $config['default_action']);
    }

    private function semantic_url($default_ctrl, $default_act)
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);

        $ctrl = !empty($pathParts[1]) ? $pathParts[1] : $default_ctrl;
        $act = !empty($pathParts[2]) ? $pathParts[2] : $default_act;

        $controllerClassName = $ctrl . 'Controller';

        $controllerClassName = 'app\\controllers\\' . $controllerClassName;
        $controller = new $controllerClassName;
        $method = 'action' . $act;
        $controller->$method();
    }
}