<?php

namespace app\controllers;
use core\classes\SysAssets;
use core\classes\SysAuth;
use core\classes\SysController;
use core\classes\SysModule;
use core\classes\SysView;
use core\classes\SysWidget;
use core\modules\page\models\Page;

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
class homeController extends SysController
{

    public function actionIndex()
    {
        $view = new SysView();
        $view->title = 'Добро пожаловать';
        $view->display('index');
    }

    public function actionDemo()
    {
        $model = new Page();
        $view = new SysView();
        $view->model = $model;
        $view->display('demo');
    }

}