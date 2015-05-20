<?php

namespace app\controllers;
use core\classes\cauth;
use core\classes\ccontroller;
use core\classes\cview;
use core\classes\cwidget;
use core\modules\page\models\page;

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
        $view->title = 'Добро пожаловать';
        $view->display('index');
    }

    public function actionDemo()
    {
        $model = new Page();
        $view = new Cview();
        $view->model = $model;

        $view->display('demo');
    }

}