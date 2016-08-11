<?php

namespace core\system;

use core\system\Lucent;

class CView
{
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

		echo $content;
	}
}