<?php
/**
 * Created by PhpStorm.
 * User: Rabota
 * Date: 10.08.2016
 * Time: 16:23
 */

namespace app\controllers;
use core\system\CView;
use app\classes\SystemController;

class NewsController extends SystemController
{
    /**
     * Буферизация в php
     */
    public function actionIndex()
    {
        $view = new CView();
        $view->render('index');
    }

    public function actionCreate()
    {
        $view = new CView();
        $view->render('create');
        

        // Это в Views::render()
    }

    /**
     * after all
     * Работа с классом Views
     * Геттеры
     * Сеттеры
     */
    public function actionView()
    {
        $header = 'Page Header';

         $view = new CView();
         $view->render('view', [
          'header' => $header,
        ]);
    }
}