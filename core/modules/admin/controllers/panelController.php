<?php
namespace core\modules\admin\controllers;


use core\classes\cauth;
use core\classes\Cbreadcrumbs;
use core\classes\ccontroller;
use core\classes\Cmodule;
use core\classes\cview;

class PanelController extends Ccontroller
{
    /**
     * @todo в ccontroller сделать метод, которому будет передаваться лишь название вызываемого
     * экшена (это в url классе). Этот метод будет переберать все пермишены, и находить описанный метод
     * Затем сравнивать роль текущенго пользователя и роли переданные в пермишене
     */
    public static function permission()
    {
        // "-" - неавторизованный пользователь
        return [
            'index' => ['user', '-'],
            'modules' => ['user', '-'],
        ];
    }

    public function breadcrumbs()
    {
        return [
            'index' => [
                'админ панель' => '-',
            ],

            'modules' => [
                'админ панель' => '/admin/panel/',
                'модули' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'index');

        $view = new Cview();
        $view->breadcrumbs = $breadcrumbs;
        $view->display('index');
    }

    public function actionModules()
    {
        $breadcrumbs = Cbreadcrumbs::getAll($this, 'modules');

        $view = new Cview();
        $modules = Cmodule::getAllModules();
        $view->modules = $modules;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('modules');
    }

}