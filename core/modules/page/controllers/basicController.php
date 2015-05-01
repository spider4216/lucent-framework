<?php
namespace core\modules\page\controllers;

use core\classes\Ccontroller;
use core\classes\Cview;
use core\modules\page\models\Page;

class basicController extends Ccontroller{

    public function actionIndex()
    {
        $model = Page::findAll();

        $view = new Cview();
        $view->content = $model;

        $view->display('index');
    }
}