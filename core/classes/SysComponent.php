<?php

namespace core\classes;


class SysComponent
{
	private $components = [];

	public function __set($name, $value)
	{
		$this->components[$name] = $value;
	}

	public function __get($name)
	{
		return $this->components[$name];
	}
}