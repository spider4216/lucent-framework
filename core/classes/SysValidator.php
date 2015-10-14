<?php

namespace core\classes;

use core\classes\SysMessages;

class SysValidator
{

    private $compare_data = [];
    private $model;
    private $data;
    private $errors = [];

    public function __construct($modelName)
    {
        $this->model = new $modelName();
    }

    public function check($name, $v_name, $data)
    {
        $this->data = $data;
        $post = SysRequest::post();
        if (isset($this->data[$name])) {
            if (method_exists($this, $v_name)) {
                return $this->$v_name($this->data[$name], $name);
            } else {
                SysMessages::set(_("Rule") . ' ' . $v_name . ' ' . _("does not exist"), 'danger');
            }
        }

        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    //$v - значение атрибута
    //$name - наименование атрибута

    private function required($v, $name)
    {
        if (!empty($v)) {
            return true;
        }

        $attrLabel = $this->model->getLabel($name);

        $message = _("Field") . ' "' . $attrLabel . '" ' . 'can not be empty';

        $this->errors[] = $message;
        SysMessages::set($message, 'danger');
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

        $attrLabel = $this->model->getLabel($name);
        $attrLabelAgain = $this->model->getLabel($this->compare_data['name']);

        $message = _("Field value") . ' "' . $attrLabelAgain . '" ' . _("does not match") . ' "' . $attrLabel .
            '"';

        $this->errors[] = $message;
        SysMessages::set($message, 'danger');
        return false;
    }

    private function comparedPassword($v, $name)
    {
        if (SysPassword::verify($v, $this->compare_data['value'])) {
            return true;
        }

        $attrLabel = $this->model->getLabel($name);
        $attrLabelAgain = $this->model->getLabel($this->compare_data['name']);

        $message = _("Field value") . ' "' . $attrLabelAgain . '" ' . _("does not match") . ' "' . $attrLabel .
            '"';

        $this->errors[] = $message;
        SysMessages::set($message, 'danger');
        return false;
    }

    private function email($v, $name)
    {
        $result = preg_match('/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/',$v);

        if ($result) {
            return true;
        }

        $message = _("E-mail is not valid");

        $this->errors[] = $message;
        SysMessages::set($message, 'danger');
        return false;
    }

    //с ограничением 2-20 символов, которыми могут быть буквы и цифры, первый символ обязательно буква
    private function username($v, $name)
    {
        $result = preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/',$v);

        if ($result) {
            return true;
        }

        $message = _("Username or password is not valid");

        $this->errors[] = $message;
        SysMessages::set($message, 'danger');
        return false;
    }

    //Строчные и прописные латинские буквы, цифры, спецсимволы. Минимум 8 символов
    private function password($v, $name)
    {
        $result = preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/',$v);

        if ($result) {
            return true;
        }

        $message = _("Password is not valid");

        $this->errors[] = $message;

        SysMessages::set($message, 'danger');
        return false;
    }

    private function unique($v, $name)
    {
//        if ($this->model->is_new_record($name, $v)) {
//            return true;
//        }
        $id = (array_key_exists('id', $this->data)) ? $this->data['id'] : '';

        if ($this->model->isUniqueExceptRecord($name, $v, $id)) {
            return true;
        }

        $message = _("Record") . ' "' . $v . '" ' . _("has already exist");

        $this->errors[] = $message;

        SysMessages::set($message, 'danger');
        return false;
    }

    private function safe()
    {
        return true;
    }
}