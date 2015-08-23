<?php
namespace core\widgets;

use core\classes\SysWidget;

class WTree extends SysWidget
{
    public function stick($name, $model, $data)
    {
        $deleteParams = '';
        if (isset($data['buttons']['delete']['params'])) {
            foreach ($data['buttons']['delete']['params'] as $param) {
                if (isset($param['key']) && isset($param['value'])) {
                    $deleteParams .= '&' . $param['key'] . '=' . $param['value'] . '&';
                }
            }
        }

        $data['deleteParams'] = rtrim($deleteParams, '&');

        //Во вьюхе $data['nodes'] будет доступна как $data
        return $this->render($name, $model, $data);
    }
}