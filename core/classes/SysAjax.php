<?php
namespace core\classes;

/**
 * Class SysAjax
 * @package core\classes
 * Класс для работы с ajax
 */
class SysAjax
{
    public static function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ==
            'xmlhttprequest') {
            return true;
        }

        return false;
    }

    public static function json_ok($message)
    {
        echo json_encode(['status' => 'ok', 'text' => $message]);
        exit();
    }

    public static function json_err($message)
    {
        echo json_encode(['status' => 'err', 'text' => $message]);
        exit();
    }
}