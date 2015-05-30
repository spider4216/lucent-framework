<?php

namespace core\classes;

/**
 * Class SysPath
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Класс позволяет работать с путями
 */
class SysPath {
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

    /**
     * Инициализация путей
     */
    private static function path_init()
    {
        static::$root = $_SERVER['DOCUMENT_ROOT'];
        static::$core = $_SERVER['DOCUMENT_ROOT'] . '/core';
        static::$app = $_SERVER['DOCUMENT_ROOT'] . '/app';
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

}