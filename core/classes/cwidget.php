<?php

namespace core\classes;

class Cwidget {

    public static function build($name, $model, $data = null)
    {
        $show_id = false;
        $conditional = isset($data['conditional']) ? $data['conditional'] : '';

        $columns = '';
        if ($data['columns']) {
            $columns = $data['columns'];

            if (!in_array('id', $columns)) {
                $columns[] = 'id';
            } else {
                $show_id = true;
            }
        }

        $tools = [
            'buttons' => $data['buttons'],
        ];

        $items = $model->findAll($conditional, $columns);

        $class_name = 'core\\widgets\\' . $name;
        $widget = new $class_name;
        return $widget->stick($name, $model, $items, $tools, $show_id);
    }
}