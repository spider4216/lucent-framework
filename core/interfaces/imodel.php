<?php
namespace core\interfaces;

/**
 * Interface Imodel
 * @package core\interfaces
 * @version 1.0
 * @author farZa
 * @copyright 2015
 * Интерфейс для будущей системной модели
 */
interface Imodel {
    /** Сохраняет данные */
    public function save();
    /** Удаляет данные */
    public function delete();
    /** Ищет все данные */
    public static function findAll();
    /** Ищет данные по первичному ключу */
    public static function findByPk($id);
    /** Ищет данные по наименовию и значению колонки*/
    public static function findByColumn($column, $value);
}