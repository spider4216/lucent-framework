<?php
namespace core\classes;

/**
 * Class Cview
 * @package core\classes
 * @version 1.0
 * @author farZa
 * @copyright 2015
 * Системный класс Cview отвечает связь контроллера и вьюхи.
 * Для того, чтобы передать данные во вьюху, необходимо создать
 * экземпляр объекта Cview или его потомка, затем в качестве его свойств
 * задать те значения, которые должны появиться во вьюхе. После применения метода display($view)
 * в представлении будут доступны переменные, которые были заданы в качестве свойств
 * Например: $view = new Cview(); $view->title = 'Hello World'; $view->display('home/index.php');
 * В home/index.php станет доступна переменная $title
 */
class Cview {
    /**
     * @var array
     * $data - массив, который наполняется данными через магический метод __set
     */
    protected $data = [];

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
     * @todo реализовать подстановку дериктории в соответствии с наименованием контроллера
     * @todo реализовать возможность указывать вьюху без указания формата
     */
    private function render($view)
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include __DIR__ . '/../../app/views/' . $view;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @param $view
     * Отображение данных
     */
    public function display($view)
    {
        echo $this->render($view);
    }
}