<?php

namespace core\classes;


class Cdisplay {

    protected $data = [];

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get($k)
    {
        return $this->data[$k];
    }

    public function render($path, $return = false)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include Path::directory('root') . '/' . $path . '.php';

        $content = ob_get_contents();
        ob_end_clean();

        if (!$return) {
            echo $content;
            return true;
        }

        return $content;
    }
}
