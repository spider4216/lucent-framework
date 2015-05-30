<?php

namespace core\classes;

use core\classes\SysFileManager;
use core\classes\SysPath;

/**
 * Class SysAssets
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * SysAssets - системный класс, где сосредоточена вся логика
 * подготовки и подключения стилей, скриптов и т.д.
 */
class SysAssets {

    /**
     * @var array $style
     * Данное свойство будет накапливать пути со стилями в порядке
     * их подключения. Чтобы начать накаплиать стили в массив
     * необходимо воспользоваться методом setAssets
     */
    private static $style = [];

    /**
     * @var array $script
     * Данное свойство будет накапливать пути со скриптами в порядке
     * их подключения. Чтобы начать накаплиать скрипты в массив
     * необходимо воспользоваться методом setAssets
     */
    private static $script = [];

    /**
     * Данный метод запускается при создании текущего класса.
     * Подготваливает все системные скрипты и стили для подключения
     * Подготовленные скрипты в этом методе будут доступны на любой странице
     * экшена
     */
    public static function initCoreAssets()
    {
        SysAssets::setAssets('jquery/external/jquery/jquery.js', 'system');
        SysAssets::setAssets('jquery/jquery-ui.min.js', 'system');
        SysAssets::setAssets('jquery/jquery-ui.theme.min.css', 'system');
        SysAssets::setAssets('jquery/jquery-ui.structure.min.css', 'system');
        SysAssets::setAssets('jquery/jquery-ui.min.css', 'system');

        SysAssets::setAssets('bootstrap/css/bootstrap.min.css', 'system');
        SysAssets::setAssets('bootstrap/css/bootstrap-theme.min.css', 'system');
        SysAssets::setAssets('bootstrap/js/bootstrap.min.js', 'system');
        SysAssets::setAssets('bootstrap/js/bootstrap-tooltip.js', 'system');
        SysAssets::setAssets('bootstrap/js/bootstrap-confirmation.js', 'system');

        SysAssets::setAssets('lucent/css/style.css', 'system');
        SysAssets::setAssets('lucent/js/script.js', 'system');
    }

    /**
     * Данный метод сравнивает закрытую системную директорию с ассетами в /core и
     * открытую директорию в /app. Если какие либо основные директории (те, которые находятся в корне
     * /app/assets/system) отсутствуют, производится автоматическое копирование недостающих
     * директорий с /core/assets в /app/assets/system
     */
    public static function filesAttach()
    {
        $fileManager = new SysFileManager();
        $coreAssets = $fileManager->scanDir(SysPath::directory('core') . '/assets');
        $appAssetsSystem =  $fileManager->scanDir(SysPath::directory('app') . '/assets/system');

        foreach ($coreAssets as $coreA) {
            if (!in_array($coreA, $appAssetsSystem)) {
                $fileManager->recurse_copy(
                    SysPath::directory('core') . '/assets/' . $coreA,
                    SysPath::directory('app') . '/assets/system/' . $coreA
                );
            }
        }
    }

    /**
     * @param $path
     * @param string $type
     *
     * Подготовка/накапливание/регистрация скриптов и стилей. Первым параметром передаетя
     * путь до файла. Вторым, каким типом является файл, системным или просто
     * пользовательским.
     * Системный - тот, который лежит в /core/assets/system
     * Пользовательский - тот, который лежит в /app/assets/users
     */
    public static function setAssets($path, $type = 'users')
    {
        $path_prepare = '';
        switch ($type) {
            case 'users' :
                $path_prepare = '/assets/users/' . $path;
                break;
            case 'system' :
                $path_prepare = '/assets/system/' . $path;
                break;
        }

        if (file_exists($final_path = SysPath::directory('app') . $path_prepare)) {
            $file_info = pathinfo($path_prepare);

            switch ($file_info['extension']) {
                case 'css' :
                    static::$style[] = '<link href="/app'. $path_prepare .'" rel="stylesheet">';
                    break;
                case 'js' :
                    static::$script[] = '<script src="/app'. $path_prepare .'"></script>';
                    break;
            }
        }
    }

    /**
     * @param $type
     * @return bool|string
     *
     * Достает все накопленные/зарегистрированные стили и скрипты и
     * возвращает их как строку. В качестве параметра необходимо
     * указать каким типов является подключаемый файл:
     * style или script
     */
    public static function getAssets($type)
    {
        switch ($type) {
            case 'style' :
                $result = implode('', static::$style);
                static::$style = [];
                break;
            case 'script' :
                $result = implode('', static::$script);
                static::$script = [];
                break;
            default :
                $result = false;
                break;
        }

        return $result;
    }
}