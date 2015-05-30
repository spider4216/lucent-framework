<?php

namespace core\classes;

class SysWidget {

    public static function build($name, $model, $data = null)
    {
        $class_name = 'core\\widgets\\' . $name;
        $widget = new $class_name;
        return $widget->stick($name, $model, $data);
    }

    protected function render($name, $model, $data = null)
    {
        ob_start();
        include SysPath::directory('core') . '/widgets/templates/_' . strtolower($name) . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}