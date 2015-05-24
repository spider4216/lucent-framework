<?php
namespace core\widgets;


use core\classes\cwidget;
use core\classes\path;

class Wbreadcrumbs extends Cwidget
{

    public function stick($name, $model, $data)
    {
        if (!$data) {
            return false;
        }

        return $this->render($name, $model, $data);
    }
}