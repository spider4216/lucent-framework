<?php

namespace app\controllers;
use core\classes\Ccontroller;
use core\classes\Cview;

/**
 * Class homeController
 * @package app\controllers
 * Контроллер по умолчанию. Для того, чтобы изменить контроллер по умолчанию
 * необходимо внести езменения в главном конфигурационном файле приложения
 * /app/config/main.php
 *
 * Переменные доступные в классе
 * @var string $folder - статичное свойство. Наименование папки для views. Т.Е. Где искать файл вьюхи,
 * в какой дериктории искать файл с вьюхой. По умолчанию равен наименованию котроллера
 */
class homeController extends Ccontroller
{

    public function actionIndex()
    {
        $view = new Cview();
        $view->content = 'Добро пожаловать на домашнюю страницу фраемворка lucent';
        $view->display('index');
    }

    public function actionDemo()
    {
        $view = new Cview();
        $view->display('demo');
    }
}