<?php

namespace core\classes;


class SysLocale
{
    /**
     * @param $string - string param. You can use pattern if you want to specify one or more
     * params. Use {:param} in string
     * @param array $params - specified params. Their patterns have to match patterns in string i.e.
     * ['{:param}' => 1]
     * @return string
     *
     * Translate method
     */
    public static function t($string, $params = [])
    {
        if (empty($params)) {
            return _($string);
        }

        $newString = '';

        foreach ($params as $key => $value) {
            $newString = str_replace($key, $value, _($string));
        }

        return _($newString);
    }
}