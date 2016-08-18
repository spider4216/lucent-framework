<?php

namespace core\system;

use core\system\Lucent;
use app\classes\SystemController;

class CView
{

	/*
	 * @author Sam
	 * @throws \ErrorException
	 * указываем путь до файла и выводим информацию
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
		// echo $content;
		
		ob_start();
		include SystemController::$layout;
		$cont1 = ob_get_clean();
		echo $cont1;
		
	}
}