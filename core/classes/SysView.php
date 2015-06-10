<?php
namespace core\classes;

/**
 * Class SysView
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 * Системный класс SysView отвечает связь контроллера и вьюхи.
 * Для того, чтобы передать данные во вьюху, необходимо создать
 * экземпляр объекта SysView или его потомка, затем в качестве его свойств
 * задать те значения, которые должны появиться во вьюхе. После применения метода display($view)
 * в представлении будут доступны переменные, которые были заданы в качестве свойств
 * Например: $view = new SysView(); $view->title = 'Hello World'; $view->display('home/index.php');
 * В home/index.php станет доступна переменная $title
 */
class SysView
{
    /**
     * @var array
     * $data - массив, который наполняется данными через магический метод __set
     */
    protected $data = [];

    public function __construct()
    {
        SysAssets::initCoreAssets();
        SysAssets::initModuleAssets();
    }

    /**
     * @param $k
     * @param $v
     * Сеттер обыкновенный. При попытке записать что-либо в неопределенное свойство
     * экземплра данного класса или потомка, данные пишутся в массив $data,
     * где ключ - название свойства, значение - значение
     */
    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    /**
     * @param $k
     * @return mixed
     * Геттер обыкновенный. При попытке обращения к неопределенному свойству экземпляра данного класса
     * или его потомка, данные будут браться из массива $data
     */
    public function __get($k)
    {
        return $this->data[$k];
    }

    /**
     * @param $view
     * @return string
     * Создание переменных для view и непосредственно само подключение
     * Также в методе реализована буферизация для дальнейшей обработки данных
     * Метод напрямую работает с layout
     */
    private function render($view)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }

        $pathView = SysController::$path . '/../views/' . SysController::$folder . '/' . $view . '.php';

        ob_start();
        include $pathView;

        $content = SysTokens::apply(ob_get_contents());
        ob_end_clean();

        ob_start();
        include SysController::$layout;
        $content_final = ob_get_contents();
        ob_end_clean();
        return $content_final;
    }

    /**
     * @param $view
     * Отображение данных
     */
    public function display($view, $return = false)
    {
        if ($return) {
            return $this->render($view);
        }

        echo $this->render($view);
    }
}