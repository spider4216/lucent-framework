<?php
namespace core\widgets;


use core\classes\path;

class Wbtnask
{

    public function stick($name, $model, $data)
    {
        $tools = [];

        if (!is_array($data)) {
            $data = [];
        }

        $tools['link'] = array_key_exists('link', $data) ? $data['link'] : '#';
        $tools['value'] = array_key_exists('value', $data) ? $data['value'] : 'Удалить';
        $tools['message'] = array_key_exists('message', $data) ? $data['message'] : 'Вы уверены?';
        $tools['ok_class'] = array_key_exists('ok_class', $data) ? $data['ok_class'] : 'btn btn-primary';
        $tools['ok_label'] = array_key_exists('ok_label', $data) ? $data['ok_label'] :
            "<i class='glyphicon glyphicon-ok-circle'></i> Да";
        $tools['cancel_label'] = array_key_exists('cancel_label', $data) ? $data['cancel_label'] :
            "<i class='glyphicon glyphicon-remove-circle'></i> Нет";
        $tools['attributes'] = array_key_exists('attributes', $data) ? $data['attributes'] : [
            'class' => 'btn btn-danger',
        ];

        $tools['attributes']['class'] .= ' bootstrap-confirmation';


        return $this->render($name, $tools);
    }

    private function render($name, $tools)
    {
        ob_start();
        include Path::directory('core') . '/widgets/templates/_' . strtolower($name) . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}