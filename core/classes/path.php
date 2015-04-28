<?php

namespace core\classes;

/**
 * Class Path
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Класс позволяет работать с путями
 */
class Path {
    /**
     * @var string $directory_root
     * Ссылка корня фраемворка
     */
    public static $directory_root;

    public function __construct()
    {
        self::$directory_root = $_SERVER['DOCUMENT_ROOT'];
    }
}