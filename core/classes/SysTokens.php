<?php

namespace core\classes;


class SysTokens {
    public static function apply($content)
    {
        $result = [];
        //Название модуля до 20 символов
        //Название токена до 15 символов
        $pattern = '/\%[a-z]{0,20}+\_[a-z]{0,15}+%/i';

        $x = preg_match_all($pattern, $content, $result);

        $tokens_replace = static::parseTokens($result);

        foreach ($tokens_replace as $token => $value) {
            $content = str_replace($token, $value, $content);
        }

        return $content;
    }

    private static function parseTokens($tokens)
    {
        $arr = [];
        $result = [];
        foreach ($tokens as $token) {
            foreach ($token as $t) {
                $tt = str_replace('%', '', $t);

                $token_part = explode('_', $tt);

                $moduleName = $token_part[0];
                $tokenMethod = $token_part[1];

                $pathModule = SysModule::getModulePath($moduleName);

                if (!$pathModule) {
                    continue;
                }

                $path = $pathModule . '/tokens/' . ucfirst($moduleName . 'Tokens');

                //создать экземпляр этого класса
                $className = str_replace('/', '\\', $path);
                $object = new $className;

                if (method_exists($object, $tokenMethod)) {
                    $result[$t] = $object->$tokenMethod();
                }

                $arr[] = $result;
            }
        }

        return $result;
    }
}