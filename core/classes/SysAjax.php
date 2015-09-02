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

    public static function json_ok($message, $data = [])
    {
        $result = [
            'status' => 'ok',
            'text' => $message
        ];

        if (!empty($data)) {
            $result = array_merge($result, $data);
        }

        echo json_encode($result);
        exit();
    }

    public static function json_err($message, $data = [])
    {
        $result = [
            'status' => 'err',
            'text' => $message
        ];

        if (!empty($data)) {
            $result = array_merge($result, $data);
        }

        echo json_encode($result);
        exit();
    }
}