<?php

namespace core\classes;


class SysPassword {
    public static function hash($password)
    {
        return md5($password);
    }
}