<?php
namespace core\classes;

use core\classes\SysDatabase;
use core\interfaces\IModel;
use \Iterator;
use core\classes\SysValidator;

/**
 * Class SysModel. Системный класс модели.
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 */
abstract class SysModel implements IModel, Iterator
{

    /**
     * $table - статическое свойство, которое ожидает заполнения в конечной модели.
     * Указать наименование таблицы в конечной модели для работы с ней
     * По умолчанию данное свойство хранит наменование таблицы в точности повторяющее
     * наименование вызываемой модели в нижнем регистре
     */
    protected static $table;

    protected static $innerJoin = false;

    /**
     * @var array $data
     * Массив в который записываются и читаются данные при помощи __get и __set
     */
    protected $data = [];

    /**
     * @var bool
     * Имя сценария для правил валидации
     */
    protected static $script = false;

    /**
     * Конструктор системной модели
     */
    public function __construct()
    {
        $this->defaultTable();
    }

    protected static function labels()
    {
        return false;
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
        return isset($this->data[$key]) ? $this->data[$key] : false;
    }

    /**
     * @return bool
     * Приватное свойство, которое напрямую используется в методе save()
     * Добавляет новую запись в базу данных
     */
    private function insert()
    {
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
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
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
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

    public function form_validate()
    {
        $rules = static::rules();
        $modelName = get_called_class();

        $validator = new SysValidator($modelName);

        $result = [];

        foreach ($rules as $part) {
            foreach ($part as $attr => $rule) {

                if (array_key_exists('script', $rule)) {
                    if ($modelName::getScript() == $rule['script'][0]) {
                        foreach ($rule as $v_name) {
                            if (is_array($v_name)) {
                                continue;
                            }
                            $result[] = $validator->check($attr, $v_name, $this->data);
                        }
                    }
                    continue;
                }

                foreach ($rule as $v_name) {
                    $result[] = $validator->check($attr, $v_name, $this->data);
                }

            }
        }


        if (in_array(false, $result)) {
            return false;
        }

        return true;
    }

    public function beforeSave()
    {
        return true;
    }

    /**
     * @return bool
     * Публичный метод save(), который в зависимости от того, новая запись или нет
     * добавляет или обновляет запись в БД
     */
    public function save()
    {
        if (!$this->beforeSave()) {
            return false;
        }

        if (!$this->form_validate()) {
            return false;
        }

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
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
        return  $db->execute($sql, [':id'=>$this->id]);
    }

    /**
     * @return array
     * Возвращает все найденные записи выбранной модели
     */
    public static function findAll($condition = [], $columns = [], $order = ['id' => 'DESC'])
    {
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
        $class = get_called_class();
        $db->setClassName($class);

        $select = ($columns) ? implode(',', $columns) : '*';

        $sql = 'SELECT '. $select .' FROM ' . static::$table .
            ' ORDER BY ' . key($order) . ' ' . $order[key($order)];

        if ($condition) {
            $sql = 'SELECT '. $select .' FROM ' . static::$table .
                ' WHERE ' . $condition[0] . ' ORDER BY ' . key($order) . ' ' . $order[key($order)];
            return $db->query($sql, $condition[1]);
        }

        return $db->query($sql);
    }

    /**
     * @param $id
     * @return mixed
     * Возвращает одну единственную запись по первичному ключу
     */
    public static function findByPk($id)
    {
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
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
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
        $class = get_called_class();
        $db->setClassName($class);
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :value';
        $res =  $db->query($sql, [':value' => $value]);
        if (!empty($res)) {
            return $res[0];
        }
        return false;
    }

    public function is_new_record($column, $value)
    {
        if (!static::findByColumn($column, $value)) {
            return true;
        }

        return false;
    }

    /**
     * Если запись уникальна (за исключением самого себя)
     */
    public function isUniqueExceptRecord($column, $value, $id)
    {
        /** @var SysDatabase $db */
        $db = SysDatabase::getObj();
        $class = get_called_class();
        $db->setClassName($class);

        if (empty($id)) {
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :value';
        } else {
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' = :value AND id <> ' . $id;
        }

        $res =  $db->query($sql, [':value' => $value]);
        if (!empty($res)) {
            return false;
        }
        return true;
    }

    /**
     * @param $name
     * @return bool|string
     * Возвращает наименование атрибута, если его описали в labels в модели
     */
    public function getLabel($name)
    {
        $labels = static::labels();
        if (false != $labels) {
            if (array_key_exists($name, $labels)) {
                return $labels[$name];
            }
        }

        return $name;
    }

    /**
     * Начало группы мктодов, реализующих интерфейс Iterator для
     * успешного перебора свойств в цикле foreach
     */

    public function rewind()
    {
        reset($this->data);
    }

    public function current()
    {
        $var = current($this->data);
        return $var;
    }

    public function key()
    {
        $var = key($this->data);
        return $var;
    }

    public function next()
    {
        $var = next($this->data);
        return $var;
    }

    public function valid()
    {
        $key = key($this->data);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    /**
     * Конец группы мктодов, реализующих интерфейс Iterator для
     * успешного перебора свойств в цикле foreach
     */

    public static function rules()
    {
        return [];
    }

    public static function innerJoin($model, $field_relate, $field_related)
    {
        $relate_table = static::$table;
        $related_table = $model::$table;

        $sql = 'SELECT * FROM ' . $relate_table . ' INNER JOIN '.
            $related_table . ' ON ' . $relate_table . '.' . $field_relate . '=' . $related_table . '.' . $field_related;

        static::$innerJoin = $sql;

        $class = get_called_class();

        return new $class;
    }

    /**
     * @param $name
     * задать наименование сценария для правил валидации
     */
    public static function setScript($name)
    {
        static::$script = $name;
    }

    public static function getScript()
    {
        return static::$script;
    }

}