<?php

namespace core\classes;

use core\classes\exception\E400;
use core\classes\exception\E403;
use core\classes\exception\e404;

/**
 * Class SySUrl
 * @package core\classes
 * Класс для работы с URL
 */
class SySUrl
{
    /**
     * @param $default_ctrl - контроллер по умолчанию - приходит из App
     * @param $default_act - действие по умолчанию - приходит из App
     *
     * Метод распознавания url
     * шаблоны:
     * <domain><controller><action>
     * <domain><module><controller><action>
     */
    public static function semantic_url($default_ctrl, $default_act)
    {
        //Получаю текущий url
        $request_url = self::getUrl();
        $display = new SysDisplay();
        //Распарсиваю ссылку
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        //И разбиваю ее по частям
        $pathParts = explode('/', $path);

        //Если в урл передали больше или равно 4 частей (первый нулевой), тогда это модуль
        if (count($pathParts) >= 4) {
            $module = $pathParts[1];
            //Даем знать классу SysModule о наименовании текущего модуля
            SysModule::$moduleName = $module;
            $namespace = 'core\\modules\\'. $module .'\\controllers\\';

            //Если контроллер или действие не были переданы - устанавливаем их по умолчанию (те, что в
            // конфигурационном файле)
            $ctrl = !empty($pathParts[2]) ? $pathParts[2] : $default_ctrl;
            $act = !empty($pathParts[3]) ? $pathParts[3] : $default_act;

            $controllerClassName = $ctrl . 'Controller';
            $controllerClassNameFull = $namespace . $controllerClassName;

            if (!class_exists($controllerClassNameFull)) {
                SysMessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            }
        } else {
            //В случае если были открыт не модуль - то получаем другие части url
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


        /** @var SysController $controller*/
        try {
            //Проверяется доступ к действию
            if ($controller->allow_action($act)) {
                //Если доступ разрешен, запускается предварительный метод, который может быть
                //переопределен в желаемом контроллере
                $controller->beforeAction();
                //Запуск действия
                $controller->$method();
                //Запускается метод, который может быть переопределен в желаемом контроллере
                $controller->afterAction();
            } else {
                //Если доступ запрещен - отображается ошибка
                SysMessages::set('Доступ запрещен','danger');
                $display->render('core/views/errors/403', false, true);
            }
            //Отлов выброшенных исключений
        } catch (\Exception $e) {
            if ($e instanceof E404) {
                SysMessages::set('Страница '. $request_url .' не найдена','danger');
                $display->render('core/views/errors/404', false, true);
            } elseif ($e instanceof E403) {
                SysMessages::set('Доступ к странице '. $request_url .' запрещен','danger');
                $display->render('core/views/errors/403', false, true);
            } elseif ($e instanceof E400) {
                SysMessages::set('Негодный запрос к странице '. $request_url,'danger');
                $display->render('core/views/errors/400', false, true);
            }
        }
    }

    /**
     * @return mixed
     * Получаю текущий URL
     */
    public static function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}