<?php

namespace core\classes;

use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\exception\e404;
use core\classes\SysRequest;

class SySUrl
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
        $request_url = SysRequest::getUrl();
        $display = new SysDisplay();
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);

        //Если в урл передали больше или равно 4 частей (первый нулевой), тогда это модуль
        if (count($pathParts) >= 4) {
            $module = $pathParts[1];
            //Даем знать классу SysModule о наименовании текущего модуля
            SysModule::$moduleName = $module;
            $namespace = 'core\\modules\\'. $module .'\\controllers\\';

            $ctrl = !empty($pathParts[2]) ? $pathParts[2] : $default_ctrl;
            $act = !empty($pathParts[3]) ? $pathParts[3] : $default_act;

            $controllerClassName = $ctrl . 'Controller';
            $controllerClassNameFull = $namespace . $controllerClassName;

            if (!class_exists($controllerClassNameFull)) {
                SysMessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            }
        } else {
            $namespace = 'app\\controllers\\';

            $ctrl = !empty($pathParts[1]) ? $pathParts[1] : $default_ctrl;
            $act = !empty($pathParts[2]) ? $pathParts[2] : $default_act;

            $controllerClassName = $ctrl . 'Controller';
            $controllerClassNameFull = $namespace . $controllerClassName;

            if (!class_exists($controllerClassNameFull)) {
                SysMessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            }
        }

        SysController::$currentName = $controllerClassNameFull;
        SysController::$currentActionName = $act;
        $controller = new $controllerClassNameFull;
        $method = 'action' . $act;


        try {
            if ($controller->allow_action($act)) {
                $controller->beforeAction();

                $controller->$method();
                $controller->afterAction();
            } else {
                SysMessages::set('Доступ запрещен','danger');
                $display->render('core/views/errors/403', false, true);
            }
        } catch (E404 $e) {
            SysMessages::set('Страница '. $request_url .' не найдена','danger');
            $display->render('core/views/errors/404', false, true);
        }
    }
}