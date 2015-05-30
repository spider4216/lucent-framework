<?php
namespace core\modules\admin\controllers;


use core\classes\SysAuth;
use core\classes\SysBreadcrumbs;
use core\classes\SysController;
use core\classes\SysModule;
use core\classes\SysView;

class PanelController extends SysController
{
    /**
     * @todo в SysController сделать метод, которому будет передаваться лишь название вызываемого
     * экшена (это в SysUrl классе). Этот метод будет переберать все пермишены, и находить описанный метод
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
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'index');

        $view = new SysView();
        $view->breadcrumbs = $breadcrumbs;
        $view->display('index');
    }

    public function actionModules()
    {
        $breadcrumbs = SysBreadcrumbs::getAll($this, 'modules');

        $view = new SysView();
        $modules = SysModule::getAllModules();
        $view->modules = $modules;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('modules');
    }

}