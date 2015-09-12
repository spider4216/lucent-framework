<?php

namespace core\classes;

use core\classes\SysDisplay;

/**
 * Class SysMessages
 * @package core\classes
 *
 * type: success, info, warning, danger
 * Класс для работы с пуш сообщениями (уведомлениями)
 */

class SysMessages
{

    /**
     * @param string $text - тест сообщения
     * @param string $type - 1 из 4 типов (success, info, warning, danger)
     * Позволяет задать сообщение
     */
    public static function set($text, $type)
    {
        $_SESSION['messages'][$type][] = $text;
    }

    /**
     * @param string $type - тип сообщения (success, info, warning, danger)
     * @return array|bool
     * Позволяет получить конкретный тип сообщения
     */
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

    /**
     * @return array|bool
     * Получить все типы сообщений
     */
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

    /**
     * @param $messagesArray - массив с сообщениями - результат метода getAll()
     * @return mixed
     * Возвращает красивый вариант сообщений
     */
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