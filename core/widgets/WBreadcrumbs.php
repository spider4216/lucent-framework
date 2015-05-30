<?php
namespace core\widgets;


use core\classes\SysWidget;
use core\classes\SysPath;

class WBreadcrumbs extends SysWidget
{
    public function stick($name, $model, $data)
    {
        if (!$data) {
            return false;
        }

        return $this->render($name, $model, $data);
    }
}