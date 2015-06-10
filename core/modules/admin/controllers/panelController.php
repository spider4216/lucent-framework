<?php
namespace core\modules\admin\controllers;


use core\classes\SysAuth;
use core\extensions\ExtBreadcrumbs;
use core\classes\SysController;
use core\classes\SysModule;
use core\classes\SysView;

class PanelController extends SysController
{
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
        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'index');
        $view = new SysView();
        $view->breadcrumbs = $breadcrumbs;
        $view->display('index');
    }

    public function actionModules()
    {
        $breadcrumbs = ExtBreadcrumbs::getAll($this, 'modules');

        $view = new SysView();
        $modules = SysModule::getAllModules();
        $view->modules = $modules;
        $view->breadcrumbs = $breadcrumbs;

        $view->display('modules');
    }

}