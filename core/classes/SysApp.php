<?php

namespace core\classes;

class SysApp
{
	private $items = [];

	public function __set($name, $value)
	{
		$this->items[$name] = $value;
	}

	public function __get($name)
	{
		return $this->items[$name];
	}
}