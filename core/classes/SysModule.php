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

    /**
     * @param string $type - тип модулей: system - системный, в будущем будет пользовательский
     * @return array - возвращается массив с конфигурационными данными модулей
     * todo - сделать конфигурационный файлы модулей в json
     */
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

    public static function getModulePath($name)
    {
        $path = SysPath::directory('core') . '/modules/' . strtolower($name);

        if (!file_exists($path)) {
            $path = SysPath::directory('app') . '/modules/' . strtolower($name);

            if (!file_exists($path)) {
                return false;
            }

            $path = 'app/modules/' . strtolower($name);
        } else {
            $path = 'core/modules/' . strtolower($name);
        }

        return $path;
    }

    /**
     * @return bool|string
     * Возвращает текущее наименование модуля или false - если пользователь находится не в модуле
     */
    public static function getCurrentModuleName() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', $path);

        if (count($pathParts) >=4) {
            return $pathParts[1];
        }

        return false;
    }
}