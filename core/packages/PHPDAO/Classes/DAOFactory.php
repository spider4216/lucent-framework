<?php

namespace Classes;

use DAOFactories\MySQLDAOFactory;

/**
 * @author farZa
 * Class DAOFactory
 * Abstract generator DAO objects
 * Class was developed according to Factory Method Pattern
 * DAOFactory can create DAO generators. Generators can have many different types
 * Examples:
 *  - DAO Mysql
 *  - DAO PostgreSQL
 * etc.
 */
abstract class DAOFactory
{
	/**
	 * @author farZa
	 * List of DAO generators's types
	 */
	const MYSQL = 1;

	/**
	 * @author farZa
	 * List of DAO generators's types
	 */
	const POSTGRESQL = 2;


	/**
	 * @author farZa
	 * @return mixed
	 * Here methods for each DAO, which can be created.
	 * This methods have to be realized by particular generators.
	 */
	public abstract function generalDAO();

	/**
	 * @author farZa
	 * @param int $DAOFactory - номер генератора (смотрите константы)
	 * @return DAOFactory
	 * @throws \Exception
	 * Return generator by id
	 */
	public static function initial(int $DAOFactory):DAOFactory
	{
		switch ($DAOFactory) {
			case self::MYSQL :
				return new MySQLDAOFactory();
				break;
//			case self::POSTGRESQL :
//				return new PostgreSQLDAOFactory();
//				break;
		}

		throw new \Exception('DAO object does not exist');
	}
}