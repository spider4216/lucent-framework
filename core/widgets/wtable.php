<?php
namespace core\widgets;


use core\classes\Path;

class Wtable {

    public function stick($name, $model, $items)
    {
        return $this->render($name, $model, $items);
    }

    private function render($name, $model,  $items)
    {
        ob_start();
        include Path::directory('core') . '/widgets/templates/_' . strtolower($name) . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}