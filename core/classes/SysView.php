<?php

namespace core\classes;

use core\system\Lucent;
use core\classes\SystemController;

/**
 * @author farZa
 * Class SysView
 * @package core\classes
 * Класс для работы с представлением
 */
class SysView
{

	/*
	 * @author farZa
	 * @param string $path - Наименование представления
	 * @param array $data - переменные, которые будут доступны в представлении
	 * @throws \ErrorException
	 * Рендерим представление
	 */
	public static function render(string $path, array $data = [])
	{
		$fullPath = __DIR__ . '/../../app/views/' . Lucent::$app->components->info->currentController . '/' . $path . '.php';

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