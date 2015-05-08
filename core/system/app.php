<?php
namespace core\system;
use core\classes\casset;
use core\classes\cmodule;
use core\classes\path;

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

    /**
     * @param $default_ctrl
     * @param $default_act
     *
     * Метод распознавания url
     * шаблоны:
     * <domain>/<controller>/<action>
     * <domain>/<module>/<controller>/<action>
     * Сначала модуль ищется в системной папке, если он там отсутствует,
     * приложение пытается найти его в папке /app/modules
     */
    private static function semantic_url($default_ctrl, $default_act)
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);

        $pathCtrlIndex = 1;
        $pathActIndex = 2;
        $namespace = 'app\\controllers\\';
        if (count($pathParts) > 3) {
            $pathModuleIndex = 1;
            $pathCtrlIndex = 2;
            $pathActIndex = 3;

            $module = $pathParts[$pathModuleIndex];
            Cmodule::$moduleName = $module;
            $namespace = 'core\\modules\\'. $module .'\\controllers\\';
        }

        $ctrl = !empty($pathParts[$pathCtrlIndex]) ? $pathParts[$pathCtrlIndex] : $default_ctrl;
        $act = !empty($pathParts[$pathActIndex]) ? $pathParts[$pathActIndex] : $default_act;

        $controllerClassName = $ctrl . 'Controller';

        $controllerClassNameFull = $namespace . $controllerClassName;

        if (!class_exists($controllerClassNameFull)) {
            $namespace = 'app\\modules\\'. $module .'\\controllers\\';
            $controllerClassNameFull = $namespace . $controllerClassName;
        }

        $controller = new $controllerClassNameFull;
        $method = 'action' . $act;
        $controller->$method();
    }
}