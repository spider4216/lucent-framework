<?php
namespace core\widgets;


use core\classes\Path;

class Wtable {

    public function stick($name, $model, $items, $tools, $show_id = false)
    {
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