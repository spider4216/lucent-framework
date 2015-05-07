<?php

namespace core\classes;

class Cwidget {

    public static function build($name, $model, $data = null)
    {
        $conditional = isset($data['conditional']) ? $data['conditional'] : '';
        $columns = isset($data['columns']) ? $data['columns'] : '';
        $tools = [
            'buttons' => $data['buttons'],
        ];

        $items = $model->findAll($conditional, $columns);

        $class_name = 'core\\widgets\\' . $name;
        $widget = new $class_name;
        return $widget->stick($name, $model, $items, $tools);
    }
}