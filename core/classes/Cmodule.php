<?php
namespace core\classes;

/**
 * Class Cmodule
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Системный класс модуля
 */
class Cmodule
{
    /**
     * @var string $moduleName
     * Наименование модуля. Инициализируется в главнойм классе
     * приложения App. Можно использовать для того, чтобы получить
     * имия текущего модуля, который открыт в данный момент. Имя
     * модуля приходит из урла
     */
    public static $moduleName;
}