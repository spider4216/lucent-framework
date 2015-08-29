<?php

namespace core\classes;

use core\classes\SysDisplay;

/**
 * Class SysMessages
 * @package core\classes
 *
 * type: success, info, warning, danger
 */

class SysMessages
{

    public static function set($text, $type)
    {
        $_SESSION['messages'][$type][] = $text;
    }

    public static function get($type)
    {
        $message = [];
        if (isset($_SESSION['messages'][$type])) {
            $message[$type] = $_SESSION['messages'][$type];

            session_destroy();

            return $message;
        }

        return false;
    }

    public static function getAll()
    {
        if (isset($_SESSION['messages']) && $session = $_SESSION['messages']) {
            $messages = [];

            foreach ($session as $type => $message) {
                $messages[$type] = $message;
            }

            session_destroy();

            return $messages;
        }

        return false;
    }

    public static function pretty($messagesArray)
    {
        $display = new SysDisplay();
        $display->messages = $messagesArray;

        return $display->render('core/views/messages/summary', true);
    }

    /**
     * @return string
     * @param $messages - одномерный массив полученный в результате SysModel->getErrors()
     * Возвразает красивый вид для ошибок (в основном для popup при ajax)
     */
    public static function getPrettyValidatorMessages($messages)
    {
        $message = '';
        foreach ($messages as $m) {
            $message .= $m . "\n";
        }

        return $message;
    }
}