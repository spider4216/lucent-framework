<?php

namespace core\classes;

class Cwidget {

    public static function build($name, $model, $data = null)
    {
        $class_name = 'core\\widgets\\' . $name;
        $widget = new $class_name;
        return $widget->stick($name, $model, $data);
    }
}