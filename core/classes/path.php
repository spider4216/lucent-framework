<?php

namespace core\classes;

/**
 * Class Path
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Класс позволяет работать с путями
 */
class Path {
    /**
     * @var string $root
     * путь корня фраемворка в файловой системе
     */
    private static $root;

    /**
     * @var string $core
     * путь /core фраемворка в файловой системе
     */
    private static $core;

    /**
     * @var string $app
     * путь до папки /app фраемворка в файловой системе
     */
    private static $app;

    private static $views_directory;

    /**
     * Инициализация путей
     */
    private function path_init()
    {
        static::$root = $_SERVER['DOCUMENT_ROOT'];
        static::$core = $_SERVER['DOCUMENT_ROOT'] . '/core';
        static::$app = $_SERVER['DOCUMENT_ROOT'] . '/app';
        static::setViews();
    }

    /**
     * @param string $name
     * @return bool|string
     * Метод, позволяющий получить путь, передав в качестве
     * параметра нужный аргумент ('app','core', 'root' и т.д)
     */
    public static function directory($name)
    {
        static::path_init();

        switch ($name) {
            case 'root' :
                $result = static::$root;
                break;
            case 'core' :
                $result = static::$core;
                break;
            case 'app' :
                $result = static::$app;
                break;
            default :
                $result = false;
        }

        return $result;
    }

    /**
     * @param string $type
     * @return mixed
     * Возвращает пути до папки views в зависимости от переданного типа:
     * default - стандартная директория в /app/views
     * coreModules - модульная системная директория /core/modules/views
     * appModules - модульная директория в приложении /app/modules/views
     */
    public static function setViews($type = 'default') {
        switch ($type) {
            case 'default' :
                static::$views_directory = $_SERVER['DOCUMENT_ROOT'] . '/app/views';
                break;
            case 'coreModules' :
                static::$views_directory = $_SERVER['DOCUMENT_ROOT'] . '/core/modules/'. Cmodule::$moduleName .'/views/';
                break;
            case 'appModules' :
                static::$views_directory = $_SERVER['DOCUMENT_ROOT'] . '/app/modules/'. Cmodule::$moduleName .'/views';
                break;
        }

        return static::$views_directory;
    }
}