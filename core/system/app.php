<?php
namespace core\system;
use core\classes\SysAssets;
use core\classes\SysModule;
use core\classes\SysPath;
use core\classes\SysUrl;

/**
 * Class App
 * @package app\core\system
 *
 * App - главный класс всего приложения.
 */
class App
{
    public static $config;

    //Главный метод класса. Вся инициализация приложения проходит через этот метод.
    public static function run()
    {
        header('Content-Type: text/html; charset=utf-8');
        session_start();
        static::$config = include __DIR__ . '/../../app/config/main.php';
        SysAssets::filesAttach();
        SysAssets::moduleFilesAttach();

        SysUrl::semantic_url(static::$config['default_controller'], static::$config['default_action']);
    }
}