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
 */
class homeController extends Ccontroller
{

    public function actionIndex()
    {
        $view = new Cview();
        $view->content = 'Добро пожаловать на домашнюю страницу фраемворка lucent';
        $view->display('home/index.php');
    }
}