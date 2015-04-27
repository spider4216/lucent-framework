<?php
namespace core\classes;

use core\classes\Database;
use core\interfaces\Imodel;

/**
 * Class Cmodel. Системный класс модели.
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 */
abstract class Cmodel implements Imodel
{

    /**
     * $table - статическое свойство, которое ожидает заполнения в конечной модели.
     * Указать наименование таблицы в конечной модели для работы с ней
     * По умолчанию данное свойство хранит наменование таблицы в точности повторяющее
     * наименование вызываемой модели в нижнем регистре
     */
    protected static $table;

    /**
     * @var array $data
     * Массив в который записываются и читаются данные при помощи __get и __set
     */
    protected $data = [];

    /**
     * Конструктор системной модели
     */
    public function __construct()
    {
        $this->defaultTable();
    }

    /**
     * defaultTable() задает свойству $table имя таблицы, идиентичное имени модели
     */
    private function defaultTable()
    {
        $class_namespace = explode('\\', get_called_class());
        $class_name = array_pop($class_namespace);
        self::$table = strtolower($class_name);
    }

    /**
     * @param $key
     * @param $value
     * Сеттер обыкновенный. При попытке записать что-либо в неопределенное свойство
     * экземплра данного класса или потомка, данные пишутся в массив $data,
     * где ключ - название свойства, значение - значение
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     * Геттер обыкновенный. При попытке обращения к неопределенному свойству экземпляра данного класса
     * или его потомка, данные будут браться из массива $data
     */
    public function __get($key)
    {
        return $this->data[$key];
    }

    /**
     * @return bool
     * Приватное свойство, которое напрямую используется в методе save()
     * Добавляет новую запись в базу данных
     */
    private function insert()
    {
        /** @var Database $db */
        $db = Database::getObj();
        $cols = array_keys($this->data);
        $colsPrepare = array_map(function($col_name) { return ':' . $col_name;}, $cols);
        $dataExec = [];
        foreach ($this->data as $key => $value) {
            $dataExec[':' . $key] = $value;
        }
        $sql = 'INSERT INTO ' . static::$table . ' (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $colsPrepare) . ') ';
        $result =  $db->execute($sql, $dataExec);

        if (true == $result) {
            $this->id = $db->lastInsertId();
        }

        return $result;
    }

    /**
     * @return bool
     * Приватное свойство, которое напрямую используется в методе save()
     * Обновляет запись в таблице
     */
    private function update()
    {
        /** @var Database $db */
        $db = Database::getObj();
        $data = [];
        $dataExec = [];
        foreach ($this->data as $key=>$value) {
            $dataExec[':' . $key] = $value;
            if ($key == 'id') {
                continue;
            }
            $data[] = $key . ' = :' . $key;
        }
        $sql = 'UPDATE ' . static::$table . ' SET ' . implode(', ', $data) . ' WHERE id=:id';
        return  $db->execute($sql, $dataExec);
    }

    /**
     * @return bool
     * Публичный метод save(), который в зависимости от того, новая запись или нет
     * добавляет или обновляет запись в БД
     */
    public function save()
    {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * @return bool
     * Удаляет найденную запись
     */
    public function delete()
    {
        /** @var Database $db */
        $db = Database::getObj();
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
        return  $db->execute($sql, [':id'=>$this->id]);
    }

    /**
     * @return array
     * Возвращает все найденные записи выбранной модели
     */
    public static function findAll()
    {
        /** @var Database $db */
        $db = Database::getObj();
        $class = get_called_class();
        $db->setClassName($class);
        $sql = 'SELECT * FROM ' . static::$table;
        return $db->query($sql);
    }

    /**
     * @param $id
     * @return mixed
     * Возвращает одну единственную запись по первичному ключу
     */
    public static function findByPk($id)
    {
        /** @var Database $db */
        $db = Database::getObj();
        $class = get_called_class();
        $db->setClassName($class);
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id=:id';
        return $db->query($sql, [':id'=>$id])[0];
    }

    /**
     * @param string $column - наименование колонки
     * @param mixed $value - значение колонки
     * @return bool || array
     * Возвращает данные найденой записи по колонке или false в случае отсутствия данных
     */
    public static function findByColumn($column, $value)
    {
        /** @var Database $db */
        $db = Database::getObj();
        $class = get_called_class();
        $db->setClassName($class);
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :value';
        $res =  $db->query($sql, [':value' => $value]);
        if (!empty($res)) {
            return $res[0];
        }
        return false;
    }
}