<?php
namespace core\classes;

/**
 * Class SysDatabase - класс для работы с БД на низком уровне
 * @package core\classes
 * @version 1.1
 * @author farZa
 * @copyright 2015
 *
 * Класс реализует распространенный шаблон проектирования singleton, для
 * экономии ресурсов и улучшения производительности
 */
class SysDatabase
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
     * в SysModel вернется массив, где каждый его элемент будет являться объектом заданного в
     * $class класса, где его свойства и будут являться теми данными выбранными из БД.
     */
    private $class = 'stdClass';

    /**
     * Конструктор, где описана логика соединения с БД. Используется лишь 1 раз (singleton)
     */
    private function __construct()
    {
        $databaseConfig = file_get_contents(__DIR__ . '/../../app/config/database.json');
        $db_data = json_decode($databaseConfig, true);

        $dsn = 'mysql:dbname=' . $db_data['db_name'] . ';host=' . $db_data['db_host'];
        $this->pdo = new \PDO($dsn, $db_data['db_username'], $db_data['db_password'],array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
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

    /**
     * @param $dbName - Имя БД
     * @param $dbHost - Сервер БД
     * @param $dbUsername - Имя пользователя
     * @param $dbPassword - Пароль
     * @return bool
     * Метод проверяет соединение с конерктной базой данных
     * Возвращает true - если соединение корректно, в обратном случае - false
     */
    public static function checkDatabaseConnectionByData($dbName, $dbHost, $dbUsername, $dbPassword)
    {
        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $dbHost;
        try {
            $pdo = new \PDO($dsn, $dbUsername, $dbPassword);
        } catch(\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     * Метод проверяет соединение с базой данных.
     * Возвращает true - если соединение корректно, в обратном случае - false
     */
    public static function checkDatabaseConnection()
    {
        try {
            $db = SysDatabase::getObj();
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollBack()
    {
        $this->pdo->rollBack();
    }

    public function changeDbConnection($db_name, $db_host, $db_username, $db_password)
    {
        $dsn = 'mysql:dbname=' . $db_name . ';host=' . $db_host;
        $this->pdo = new \PDO($dsn, $db_username, $db_password, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            ]);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
    }

    /**
     * @author farZa
     * reset db pdo connection by default
     */
    public function resetDb()
    {
        $className = __CLASS__;
        return self::$obj = new $className;
    }
}