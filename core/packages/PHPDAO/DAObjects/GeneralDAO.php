<?php

namespace DAObjects;

/**
 * @author farZa
 * This interface has to be implemented by every dao class with general type
 * If you want to create other dao object with total different realization (relatively general type),
 * create new interface with your methods
 */
interface GeneralDAO
{
	public function table(string $tableName):GeneralDAO;
	public function insert(array $data):GeneralDAO;
	public function update(array $data):GeneralDAO;

	public function delete():GeneralDAO;
	public function select(string $columns):GeneralDAO;
	public function where($data, $sep = 'AND'):GeneralDAO;
	public function from(string $table):GeneralDAO;
	public function execute():bool;
	public function fetchAll():array;
	public function fetchRow():array;
}