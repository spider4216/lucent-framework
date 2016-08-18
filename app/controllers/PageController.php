<?php
//пространства имен
namespace app\controllers;

use core\system\Lucent;
use core\system\CView;;
use app\classes\SystemController;

/**
 * Class pageController
 * @author ccw
 * @package controllers
 */
class PageController  extends SystemController {

    /**
     * @author ccw
     * общедоступный функция
     */
    public function actionTest()
    {
        $view = new CView();
        $view->render('test');
        
//        echo "Test My First Action";
    }

    /**
     * @author ccw
     * общедоступный функция
     */
    public function actionHome()
    {
        $view = new CView();
        $view->render('home');
        
//        echo "My Home";
    }

    /**
     * @author
     */
    public function actionNews()
    {
        $view = new CView();
        $view->render('news');
        
//        echo '<h2>Страница новостей</h2>';
//        echo "Язык системы: " . App::getLanguage();
    }
    
}

?>

