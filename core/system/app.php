<?php
namespace core\system;
use core\classes\SysAssets;
use core\classes\SysModule;
use core\classes\SysPath;
use core\classes\SysRequest;
use core\classes\SysTranslate;
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

        self::initLanguage();
        SysAssets::filesAttach();
        SysAssets::moduleFilesAttach();

        SysUrl::semantic_url(static::$config['default_controller'], static::$config['default_action']);
    }

    private static function initLanguage()
    {
        $lang =  SysTranslate::getLanguageCode(self::$config['lang']);
        putenv("LC_ALL=" . $lang);
        setlocale(LC_ALL, $lang);

        $domain = self::$config['project_system_name'];

        bindtextdomain($domain, SysPath::directory('core') . '/locale');
        textdomain($domain);

        bind_textdomain_codeset($domain, 'UTF-8');

    }
}