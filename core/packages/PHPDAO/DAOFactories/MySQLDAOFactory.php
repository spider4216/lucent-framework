<?php

namespace DAOFactories;

use Classes\DAOFactory;
use DAObjects\MysqlDAO;
use Classes\ConnectionsPool;

/**
 * @author farZa
 * Генератор DAO объектов MySQL типа
 * Генератор принимает все необходимые данные для соединения с источником данных и генерирует
 * конкретные DAO объекты
 */
class MySQLDAOFactory extends DAOFactory
{
	/**
	 * @author farZa
	 * @var string $host
	 * Db host
	 */
	private $host;

	/**
	 * @author farZa
	 * @var string $dbName
	 * Name of database
	 */
	private $dbName;

	/**
	 * @author farZa
	 * @var string $username
	 * Username for db connection
	 */
	private $username;

	/**
	 * @author farZa
	 * @var string $password
	 * Password for db connection
	 */
	private $password;

	/**
	 * @author farZa
	 * @var \PDO $pdo
	 * Property for driver
	 */
	private $pdo;

	/**
	 * @author farZa
	 * @param string $host
	 * Setter for host
	 */
	public function setHost(string $host)
	{
		$this->host = $host;
	}

	/**
	 * @author farZa
	 * @param string $dbName
	 * Setter for db name
	 */
	public function setDbName(string $dbName)
	{
		$this->dbName = $dbName;
	}

	/**
	 * @author farZa
	 * @param string $username
	 * Setter for username
	 */
	public function setUsername(string $username)
	{
		$this->username = $username;
	}

	/**
	 * @author farZa
	 * @param string $password
	 * Setter for password
	 */
	public function setPassword(string $password)
	{
		$this->password = $password;
	}

	/**
	 * @author farZa
	 * @throws \Exception
	 * Create database connection and put it in pool
	 */
	public function createConnection()
	{
		if (!$this->host) {
			throw new \Exception('Не указан хост');
		}

		if (!$this->username && !$this->password) {
			throw new \Exception('Не указан логин или пароль');
		}

		if (!$this->dbName) {
			throw new \Exception('Не указано наименование базы данных');
		}

		$this->pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->username, $this->password);
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		ConnectionsPool::pushConnection('MysqlDAO', $this->pdo);
	}

	/**
	 * @author farZa
	 * @return MysqlDAO
	 * General DAO Object
	 */
	public function generalDAO()
	{
		return new MysqlDAO();
	}

	//Create other DAO objects if you need
}