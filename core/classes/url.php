<?php

namespace core\classes;

use core\classes\cdisplay;
use core\classes\cmessages;
use core\classes\exception\e404;
use core\classes\request;

class Url
{
    /**
     * @param $default_ctrl
     * @param $default_act
     *
     * Метод распознавания url
     * шаблоны:
     * <domain>/<controller>/<action>
     * <domain>/<module>/<controller>/<action>
     */
    public static function semantic_url($default_ctrl, $default_act)
    {
        $request_url = Request::getUrl();
        $display = new Cdisplay();
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);

        //Если в урл передали больше или равно 4 частей (первый нулевой), тогда это модуль
        if (count($pathParts) >= 4) {
            $module = $pathParts[1];
            //Даем знать классу Cmodule о наименовании текущего модуля
            Cmodule::$moduleName = $module;
            $namespace = 'core\\modules\\'. $module .'\\controllers\\';

            $ctrl = !empty($pathParts[2]) ? $pathParts[2] : $default_ctrl;
            $act = !empty($pathParts[3]) ? $pathParts[3] : $default_act;

            $controllerClassName = $ctrl . 'Controller';
            $controllerClassNameFull = $namespace . $controllerClassName;

            if (!class_exists($controllerClassNameFull)) {
                Cmessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            }
        } else {
            $namespace = 'app\\controllers\\';

            $ctrl = !empty($pathParts[1]) ? $pathParts[1] : $default_ctrl;
            $act = !empty($pathParts[2]) ? $pathParts[2] : $default_act;

            $controllerClassName = $ctrl . 'Controller';
            $controllerClassNameFull = $namespace . $controllerClassName;

            if (!class_exists($controllerClassNameFull)) {
                Cmessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            }
        }

        $controller = new $controllerClassNameFull;
        $method = 'action' . $act;


        try {
            $controller->$method();
        } catch (E404 $e) {
            Cmessages::set('Страница '. $request_url .' не найдена','danger');
            $display->render('core/views/errors/404', false, true);
        }
    }
}