<?php

namespace core\components;

class InfoComponent
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