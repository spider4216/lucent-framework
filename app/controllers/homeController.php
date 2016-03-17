<?php

namespace app\controllers;
use core\classes\SysAssets;
use core\classes\SysAuth;
use core\classes\SysController;
use core\classes\SysModule;
use core\classes\SysView;
use core\classes\SysWidget;
use core\modules\guide\models\Guide;
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
        $view->title = _('Welcome to CMF Lucent');

        $isGuide = false;
        $guide = Guide::findByColumn('machine_name', 'start');
        if (!empty($guide) && SysAuth::is_login()) {
            $isGuide = $guide->switch == 1 ? true : false;
        }

        $view->isGuide = $isGuide;
        $view->display('index');
    }

    public function actionDemo()
    {
        $model = new Page();
        $view = new SysView();
        $view->model = $model;
        $view->display('demo');
    }

    public function actionPullRequest()
    {
        echo 'test pull request';
    }

}