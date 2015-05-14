<?php

namespace core\classes;

use core\classes\cmessages;

class Cvalidator
{

    private $compare_data = [];

    public function check($name, $v_name)
    {
        $post = Request::post();
        if (isset($post[$name])) {
            if (method_exists($this, $v_name)) {
                return $this->$v_name($post[$name], $name);
            } else {
                Cmessages::set('Правило ' . $v_name . ' не существует', 'danger');
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

    private function compare($v, $name)
    {
        $this->compare_data = [
            'name' => $name,
            'value' => $v,
        ];

        return true;
    }

    private function compared($v, $name)
    {
        if ($this->compare_data['value'] == $v) {
            return true;
        }

        Cmessages::set('Значение поля ' . $this->compare_data['name'] . ' не соответствует полю ' . $name, 'danger');
        return false;
    }

    private function email($v, $name)
    {
        $result = preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/',$v);

        if ($result) {
            return true;
        }

        Cmessages::set('Email введен не корректно', 'danger');
        return false;
    }

    //с ограничением 2-20 символов, которыми могут быть буквы и цифры, первый символ обязательно буква
    private function username($v, $name)
    {
        $result = preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/',$v);

        if ($result) {
            return true;
        }

        Cmessages::set('Имя пользователя введено не корректно', 'danger');
        return false;
    }

    //Строчные и прописные латинские буквы, цифры, спецсимволы. Минимум 8 символов
    //@todo поработать с регуляркой для пароля
    private function password($v, $name)
    {
        $result = preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$v);

        if ($result) {
            return true;
        }

        Cmessages::set('Пароль введен не корректно', 'danger');
        return false;
    }
}