<?php

namespace core\classes;

use core\classes\cdisplay;

/**
 * Class Cmessages
 * @package core\classes
 *
 * type: success, info, warning, danger
 */

class Cmessages
{

    public static function set($text, $type)
    {
        $_SESSION[$type][] = $text;
    }

    public static function get($type)
    {
        if (isset($_SESSION[$type])) {
            return $_SESSION[$type];
        }

        return false;
    }

    public static function getAll()
    {
        if ($session = $_SESSION) {
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
        $display = new Cdisplay();
        $display->messages = $messagesArray;

        return $display->render('core/views/messages/summary', true);
    }

    //@todo подогнать все кроме вьюхи через общий метод рендера

}