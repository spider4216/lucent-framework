<?php

namespace DAObjects;

use Classes\ConnectionsPool;
use DAObjects\GeneralDAO;

/**
 * @author farZa
 * DAO object general type
 * You can create your own DAO object with general interface (not necessary) if you need
 */
class MysqlDAO implements GeneralDAO
{
	/**
	 * @author farZa
	 * @var array
	 * Whole query wil be stored right here
	 */
	private $query = [];

	/**
	 * @author farZa
	 * @param string $tableName
	 * @return \DAObjects\GeneralDAO
	 * Table name
	 */
	public function table(string $tableName):GeneralDAO
	{
		$this->query['table'] = $tableName;

		return $this;
	}

	/**
	 * @author farZa
	 * @param array $data
	 * @return \DAObjects\GeneralDAO
	 * Method for insert into table
	 */
	public function insert(array $data):GeneralDAO
	{
		$this->query['insert'] = $data;

		return $this;
	}

	/**
	 * @author farZa
	 * @param array $data
	 * @return \DAObjects\GeneralDAO
	 * Method for update table
	 */
	public function update(array $data):GeneralDAO
	{
		$this->query['update'] = $data;

		return $this;
	}

	/**
	 * @author farZa
	 * @return \DAObjects\GeneralDAO
	 * Method for delete from table
	 */
	public function delete():GeneralDAO
	{
		$this->query['delete'] = true;

		return $this;
	}

	/**
	 * @author farZa
	 * @param string $columns
	 * @return \DAObjects\GeneralDAO
	 * Method for select from table
	 */
	public function select(string $columns):GeneralDAO
	{
		$this->query['select'] = $columns;

		return $this;
	}

	/**
	 * @author farZa
	 * @param $data
	 * @param string $sep
	 * @return \DAObjects\GeneralDAO
	 * Query condition
	 */
	public function where($data, $sep = 'AND'):GeneralDAO
	{
		$this->query['where'] = $data;
		$this->query['sep'] = $sep;

		return $this;
	}

	/**
	 * @author farZa
	 * @param string $table
	 * @return \DAObjects\GeneralDAO
	 * Alias table()
	 */
	public function from(string $table):GeneralDAO
	{
		$this->query['table'] = $table;

		return $this;
	}

	/**
	 * @author farZa
	 * @param string $type
	 * @return array
	 * Generate data for query by type
	 * Types:
	 *  - insert
	 *  - update
	 *  - where
	 */
	private function generateValues(string $type):array
	{
		$columns = [];
		$values = [];
		$params = [];
		$set = '';

		switch ($type) {
			case 'insert' :
				foreach ($this->query['insert'] as $key => $value) {
					$columns[] = $key;
					$values[] = ':' . $key;
					$params[':' . $key] = $value;
				}

				$columnString = implode(',', $columns);
				$valueString = implode(',', $values);

				return [
					'columns' => $columnString,
					'values' => $valueString,
					'params' => $params,
				];
				break;

			case 'update' :
				foreach ($this->query['update'] as $key => $value) {
					$set .= $key . ' = :' . $key . ',';
					$params[':' . $key] = $value;
				}

				$set = rtrim($set, ',');

				return [
					'set' => $set,
					'params' => $params,
				];
				break;

			case 'where' :
				foreach ($this->query['where'] as $key => $value) {
					$values[] = $key . ' = :' . $key;
					$params[':' . $key] = $value;
				}

				$valueString = implode(' ' . $this->query['sep'] . ' ', $values);

				return [
					'condition' => $valueString,
					'params' => $params,
				];
				break;
		}

		return [];
	}

	/**
	 * @author farZa
	 * @return bool
	 * Execute query^ insert, update, delete
	 */
	public function execute():bool
	{
		/** @var \PDO $pdo */
		$pdo = ConnectionsPool::getConnection('MysqlDAO');

		if (isset($this->query['insert'])) {

			$insertResult = $this->generateValues('insert');
			$columns = $insertResult['columns'];
			$values = $insertResult['values'];
			$params = $insertResult['params'];

			$sql = 'INSERT INTO ' . $this->query['table'] . ' (' . $columns . ') VALUES (' . $values . ')';

			$stmt = $pdo->prepare($sql);

			return $stmt->execute($params);
		}

		if (isset($this->query['update'])) {
			$updateResult = $this->generateValues('update');

			$set = $updateResult['set'];
			$params = $updateResult['params'];



			$sql = 'UPDATE ' . $this->query['table'] . ' SET ' . $set;

			if (isset($this->query['where'])) {
				$whereResult = $this->generateValues('where');

				$condition = $whereResult['condition'];
				$paramsWhere = $whereResult['params'];


				$sql .= ' WHERE ' . $condition;
				$params = array_merge($params, $paramsWhere);
			}

			$stmt = $pdo->prepare($sql);

			return $stmt->execute($params);

		}

		if (isset($this->query['delete'])) {
			$params = [];

			$sql = 'DELETE FROM ' . $this->query['table'];

			if (isset($this->query['where'])) {
				$whereResult = $this->generateValues('where');

				$condition = $whereResult['condition'];
				$params = $whereResult['params'];


				$sql .= ' WHERE ' . $condition;
			}

			$stmt = $pdo->prepare($sql);
			return $stmt->execute($params);
		}

		return false;
	}

	/**
	 * @author farZa
	 * @return array
	 * Get all data from table
	 */
	public function fetchAll():array
	{
		/** @var \PDO $pdo */
		$pdo = ConnectionsPool::getConnection('MysqlDAO');

		if (!isset($this->query['select'])) {
			return [];
		}

		$sql = 'SELECT ' . $this->query['select'] . ' FROM ' . $this->query['table'];
		$params = [];


		if (isset($this->query['where'])) {
			$whereResult = $this->generateValues('where');

			$condition = $whereResult['condition'];
			$params = $whereResult['params'];


			$sql .= ' WHERE ' . $condition;
		}

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);

		return $stmt->fetchAll();
	}

	/**
	 * @author farZa
	 * @return array
	 * Get one record by condition
	 */
	public function fetchRow():array
	{
		/** @var \PDO $pdo */
		$pdo = ConnectionsPool::getConnection('MysqlDAO');

		if (!isset($this->query['select'])) {
			return [];
		}

		$sql = 'SELECT ' . $this->query['select'] . ' FROM ' . $this->query['table'];
		$params = [];


		if (isset($this->query['where'])) {
			$whereResult = $this->generateValues('where');

			$condition = $whereResult['condition'];
			$params = $whereResult['params'];


			$sql .= ' WHERE ' . $condition;
		}

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * @author farZa
	 * Reset query
	 */
	public function resetDao()
	{
		$this->query = [];
	}

}