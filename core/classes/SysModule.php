<?php
namespace core\classes;

use core\extensions\ExtFileManager;

/**
 * Class SysModule
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 *
 * Системный класс модуля
 */
class SysModule
{
    /**
     * @var string $moduleName
     * Наименование модуля. Инициализируется в главнойм классе
     * приложения App. Можно использовать для того, чтобы получить
     * имия текущего модуля, который открыт в данный момент. Имя
     * модуля приходит из урла
     */
    public static $moduleName;

    public static function getModuleInfo($name, $type = 'system')
    {
        $file = SysPath::directory('core') . '/modules/' . $name . '/' . $name . '_info.php';
        if ('app' === $type) {
            $file = SysPath::directory('app') . '/modules/' . $name . '/' . $name . '_info.php';
        }

        if (file_exists($file)) {
            return include $file;
        }

        return false;
    }

    public static function getAllModules($type = 'system')
    {
        $fileManager = new ExtFileManager();
        $directory = SysPath::directory('core') . '/modules/';
        if ('app' === $type) {
            $directory = SysPath::directory('app') . '/modules/';
        }

        $names = $fileManager->scanDir($directory);

        $modules_info = [];
        foreach ($names as $name) {
            $modules_info[] = include $directory . '/' . $name . '/' . $name . '_info.php';
        }

        return $modules_info;
    }
}