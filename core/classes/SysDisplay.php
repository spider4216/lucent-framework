<?php

namespace core\classes;

/**
 * Class SysDisplay
 * @package core\classes
 * Класс для работы с отображением пользовательского представления по ссылке
 */
class SysDisplay {

    protected $layout;

    protected $data = [];

    public function __construct($layout = false)
    {
        $this->layout = SysPath::directory('core') . '/views/layouts/default.php';
        if (false !== $layout) {
            $this->layout = SysPath::directory('root') . '/' . $layout . '.php';
        }
    }

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get($k)
    {
        return $this->data[$k];
    }

    public function render($path, $return = false, $layout = false)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include SysPath::directory('root') . '/' . $path . '.php';

        $content = SysTokens::apply(ob_get_contents());
        ob_end_clean();

        if (false == $layout) {
            if (!$return) {
                echo $content;
                exit();
            }

            return $content;
        }

        SysAssets::initCoreAssets();
        SysAssets::initModuleAssets();
        ob_start();
        include $this->layout;
        $content_final = SysTokens::apply(ob_get_contents());
        ob_end_clean();

        if (!$return) {
            echo $content_final;
            exit();
        }

        return $content_final;
    }
}
