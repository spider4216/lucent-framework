<?php
use core\system\app;
header('Content-Type: text/html; charset=utf-8');

session_start();

require_once __DIR__ . '/core/system/autoload.php';

App::run();

?>

<?php
/**
 * @todo Сделать систему отслуживания ошибок
 * @todo Вынести кодировки, сейшн дестрои и другие вспамогательные вещи в отдельный файл
 */
?>