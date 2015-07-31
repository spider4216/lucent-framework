<?php
namespace core\widgets;


use core\classes\SysWidget;
use core\classes\SysPath;

class WBtnAsk extends SysWidget
{

    public function stick($name, $model, $data)
    {
        $tools = [];

        if (!is_array($data)) {
            $data = [];
        }

        $tools['link'] = array_key_exists('link', $data) ? $data['link'] : '#';
        $tools['value'] = array_key_exists('value', $data) ? $data['value'] : _("Delete");
        $tools['message'] = array_key_exists('message', $data) ? $data['message'] : _('Are you sure?');
        $tools['ok_class'] = array_key_exists('ok_class', $data) ? $data['ok_class'] : 'btn btn-primary';
        $tools['ok_label'] = array_key_exists('ok_label', $data) ? $data['ok_label'] :
            "<i class='glyphicon glyphicon-ok-circle'></i>" . _("Yes");
        $tools['cancel_label'] = array_key_exists('cancel_label', $data) ? $data['cancel_label'] :
            "<i class='glyphicon glyphicon-remove-circle'></i>" . _("No");
        $tools['attributes'] = array_key_exists('attributes', $data) ? $data['attributes'] : [
            'class' => 'btn btn-danger',
        ];

        $tools['attributes']['class'] .= ' bootstrap-confirmation';

        //Во вьюхе $tools будет доступна как $data
        return $this->render($name, $model, $tools);
    }
}