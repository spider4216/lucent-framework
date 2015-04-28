<?php

namespace core\classes;

/**
 * Class Ccontroller
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 * Системный класс контроллера.
 */
class Ccontroller
{
    /**
     * @var string $folder
     * Свойство с наименованием дериктории, в которой должно лежать представление.
     * Это свойство возможно перегрузить в дочернем классе. Системный класс Cview дергает
     * данное свойство для получения наименования дериктории
     */
    public static $folder;

    /**
     * @var string $layout
     * Свойство с адресом до layout. По умолчанию данное свойство
     * слушает путь до /app/views/layout/default.php
     * Путь со стандартным layout можно перегрузить в любом дочернем классе.
     */
    public static $layout;

    public function __construct()
    {
        $this->folder_like_controller_name();
        $this->setLayout();
    }

    /**
     * folder_like_controller_name() - метод для получения наименования
     * будущей дериктории из класса контролера
     */
    private function folder_like_controller_name()
    {
        $folder = get_called_class();
        $folderArr = explode('\\', $folder);
        $folderName = str_replace('Controller', '', array_pop($folderArr));

        static::$folder = strtolower($folderName);
    }

    /**
     * Метод, который задает значение для layout по умолчанию. Вызывается автоматически при
     * создании экземпляра данного или дочернего класса.
     */
    private function setLayout()
    {
        static::$layout = Path::$directory_root . '/app/views/layouts/default.php';
    }

}