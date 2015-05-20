<?php
namespace core\system;
use core\classes\casset;
use core\classes\cmodule;
use core\classes\path;
use core\classes\url;

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
        Casset::filesAttach();
        Url::semantic_url(static::$config['default_controller'], static::$config['default_action']);
    }
}