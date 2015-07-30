<?php

namespace core\classes;


class SysTranslate
{
    public static function t($text)
    {
        return _($text);
    }

    public static function languagesList()
    {
        return [
            'en' => 'en_US.utf8',
            'ru' => 'ru_RU.utf8',
        ];
    }

    public static function getLanguageCode($name)
    {
        $list = self::languagesList();
        if (array_key_exists($name, $list)) {
            return $list[$name];
        }

        return false;
    }
}