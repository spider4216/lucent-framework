<?php
namespace core\widgets;


use core\classes\path;

class Wtable
{

    public function stick($name, $model, $data)
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

        return $this->render($name, $model, $items, $tools, $show_id);
    }

    private function render($name, $model, $items, $tools, $show_id)
    {
        ob_start();
        include Path::directory('core') . '/widgets/templates/_' . strtolower($name) . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}