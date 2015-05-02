<?php
namespace core\modules\page\controllers;

use core\classes\ccontroller;
use core\classes\cview;
use core\modules\page\models\page;

class basicController extends Ccontroller{

    public function actionIndex()
    {
        $model = Page::findAll();

        $view = new Cview();
        $view->content = $model;

        $view->display('index');
    }
}