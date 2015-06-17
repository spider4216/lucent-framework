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
                'список модулей' => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = 'Админ панель';
        $view = new SysView();

        $view->display('index');
    }

    public function actionModules()
    {
        static::$title = 'Список модулей';

        $view = new SysView();
        $modules = SysModule::getAllModules();
        $view->modules = $modules;

        $view->display('modules');
    }

}