<?php

namespace core\classes;

use core\classes\cmessages;

class Cvalidator
{
    public function check($name, $v_name)
    {
        $post = Request::post();
        if (isset($post[$name])) {
            if (method_exists($this, $v_name)) {
                return $this->$v_name($post[$name], $name);
            }
        }

        return false;
    }

    private function required($v, $name)
    {
        if (!empty($v)) {
            return true;
        }

        Cmessages::set('Поле ' . $name . ' не может быть пустым', 'danger');
        return false;
    }
}