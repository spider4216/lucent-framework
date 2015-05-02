<?php

namespace core\classes;

use core\classes\cfile_manager;
use core\classes\path;

/**
 * Class Casset
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Casset - системный класс, где сосредоточена вся логика
 * подготовки и подключения стилей, скриптов и т.д.
 */
class Casset {

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
     * Данный метод сравнивает закрытую системную директорию с ассетами в /core и
     * открытую директорию в /app. Если какие либо основные директории (те, которые находятся в корне
     * /app/assets/system) отсутствуют, производится автоматическое копирование недостающих
     * директорий с /core/assets в /app/assets/system
     */
    public static function filesAttach()
    {
        $fileManager = new Cfile_manager();
        $coreAssets = $fileManager->scanDir(Path::directory('core') . '/assets');
        $appAssetsSystem =  $fileManager->scanDir(Path::directory('app') . '/assets/system');

        foreach ($coreAssets as $coreA) {
            if (!in_array($coreA, $appAssetsSystem)) {
                $fileManager->recurse_copy(
                    Path::directory('core') . '/assets/' . $coreA,
                    Path::directory('app') . '/assets/system/' . $coreA
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

        if (file_exists($final_path = Path::directory('app') . $path_prepare)) {
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