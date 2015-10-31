<?php
namespace core\system;

use core\classes\SysAssets;
use core\classes\SysDatabase;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysModule;
use core\classes\SysPath;
use core\classes\SysRequest;
use core\classes\SysTranslate;
use core\classes\SysUrl;

/**
 * Class App главный системный класс всего приложения.
 * @package core\system
 *
 */
class App
{
    //Массив с конфигурационными данными приложения
    public static $config;
    //Главный метод класса. Вся инициализация приложения проходит через этот метод.
    public static function run()
    {
        //Задаем кодировку приложению
        header('Content-Type: text/html; charset=utf-8');
        //Начинаем новую сессию
        session_start();
        //Проверяем установлена ли система
        $install = self::isInstall();
        //Если система установлена - "кешируем" конфигурационный файл приложения, который был сгенерирован при установке
        if (false !== $install) {
            $config = file_get_contents(__DIR__ . '/../../app/config/main.json');
            self::$config = json_decode($config, true);
        } else {
            //Иначе отдаем стандартный файл конфигурации, который нужен для установке системы
            $config = file_get_contents(__DIR__ . '/../../app/config/main.default.json');
            self::$config = json_decode($config, true);
            //Если система не установлена и мы не находимся в модуле - установка системы, делаем редирект на установку
            if (SysModule::getCurrentModuleName() != 'install') {
                SysRequest::redirect('/install/setup/');
            }
        }

        //Устанавливаем языковую версию системы
        self::initLanguage();
        //Копируем новые (если таковые есть) файлы скриптов и каскадных стилей
        SysAssets::filesAttach();
        //Аналогично, только для модулей
        SysAssets::moduleFilesAttach();
        //Если система установлена, нужно проверить соединение с БД
        if (false !== $install) {
            //Если с соединением возникли проблемы - показываем страницу ошибки
            if (false === SysDatabase::checkDatabaseConnection()) {
                $display = new SysDisplay('core/views/layouts/install');
                SysMessages::set(_("Error: bad database connection"), 'danger');
                //todo - если производится рендер - это должно означать, что все что после него не должно восприниматься
                $display->render('core/views/errors/403',false,true);
                exit();
            }
        }
        //Распознаем URL
        SysUrl::semantic_url(static::$config['default_controller'], static::$config['default_action']);
    }

    /**
     * return void
     * Метод устанавливает языковую версию системы, указанную в конфигурационном файле
     */
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

    /**
     * Метод проверяет установлена ли система
     * Возвращает false - если пользователь находится на странице с установкой
     * Возвращает true - если ситема установлена
     * Производит редирект на страницу установки если система не утсановлена
     *
     * Установлена ли система или нет, определяется по наличию сгенерированного конфигурационного файла приложения
     * @return bool
     */
    private static function isInstall()
    {
        $directory = SysPath::directory('app') . '/config/';
        $configName = 'main.json';
        $path = $directory . $configName;
        if (!file_exists($path)) {
            return false;
        }
        return true;
    }

    public static function getMainConfig()
    {
        $config = file_get_contents(__DIR__ . '/../../app/config/main.json');
        return json_decode($config, true);
    }
}