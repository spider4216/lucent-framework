<?php

namespace core\classes;


class Cpassword {
    public static function hash($password)
    {
        return md5($password);
    }
}