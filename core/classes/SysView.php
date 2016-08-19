<?php

namespace core\classes;

use core\system\Lucent;
use core\classes\SystemController;

class SysView
{

	/*
	 * @author farZa
	 * @throws \ErrorException
	 * Рендерим представление
	 */
	public static function render($path, $data = [])
	{
		$fullPath = __DIR__ . '/../../app/views/' . Lucent::$currentController . '/' . $path . '.php';

		if (!file_exists($fullPath)) {
			throw new \ErrorException('view cannot be found');
		}

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$$key = $value;
			}
		}

		ob_start();
		include($fullPath);
		$content = ob_get_clean();

		ob_start();
		include SystemController::$layout;
		$finalContent = ob_get_clean();
		echo $finalContent;

	}
}