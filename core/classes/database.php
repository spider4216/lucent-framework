<?php
namespace core\classes;

/**
 * Class Database - класс для работы с БД на низком уровне
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 *
 * Класс реализует распространенный шаблон проектирования singleton, для
 * экономии ресурсов и улучшения производительности
 */
class Database
{
    /**
     * @var $obj
     * Объект текущего класса со всеми его свойствами и методами. Возвращается в
     * статическом методе getObj()
     */
    protected static $obj;

    /**
     * @var \PDO
     * Объект для работы с PDO
     * Вовзращается из конструктора
     */
    public $pdo;

    /**
     * @var string
     * Класс по умолчанию. В основном перегружается на необходимый через метод setClassName.
     * Используется для возвращения выбранных данных (к примеру findAll), как массив
     * из объектов данного класса. К примеру после использование метода findAll() описанного
     * в Cmodel вернется массив, где каждый его элемент будет являться объектом заданного в
     * $class класса, где его свойства и будут являться теми данными выбранными из БД.
     */
    private $class = 'stdClass';

    /**
     * Конструктор, где описана логика соединения с БД. Используется лишь 1 раз (singleton)
     */
    private function __construct()
    {
        $db_data = include __DIR__ . '/../../app/config/database.php';
        $dsn = 'mysql:dbname=' . $db_data['db_name'] . ';host=' . $db_data['db_host'];
        $this->pdo = new \PDO($dsn, $db_data['db_username'], $db_data['db_password']);
    }

    /**
     * @param $class
     * Метод, который помогает перегрузить приватное свойство $class
     */
    public function setClassName($class)
    {
        $this->class = $class;
    }

    /**
     * Инкапсуляция клона в соответсвии с паттерном singleton
     */
    private function __clone(){}

    /**
     * @return mixed
     * Метод getObj() является ключевым методом данного класса.
     * При помощи этого статичного метода возможно получить объект данного класса.
     * Такой подход объясняется шаблоном проектирования singleton
     */
    public static function getObj()
    {
        if (!isset(self::$obj)) {
            $className =  __CLASS__;
            self::$obj = new $className;
        }
        return self::$obj;
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     * Метод execute() используется для выполнения запроса типа INSERT
     */
    public function execute($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     * Метод query() используется для выполнения запроса типа SELECT
     */
    public function query($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetchAll(\PDO::FETCH_CLASS, $this->class);
    }

    /**
     * @return string
     * Метод lastInsertId() возвращает id последней добавленной записи в БД
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}