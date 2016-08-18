<?php

namespace core\system;


class Psr0AutoloaderClass
{
	public function run()
	{
		spl_autoload_register([$this, 'autoload']);
	}

	private function autoload($className)
	{
		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		$fileName = __DIR__ . '/../../' . $fileName;

		require $fileName;
	}
}