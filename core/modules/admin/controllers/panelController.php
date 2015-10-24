<?php
namespace core\modules\admin\controllers;


use core\classes\SysAuth;
use core\classes\SysLocale;
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
                SysLocale::t("admin panel") => '-',
            ],

            'modules' => [
                SysLocale::t("admin panel") => '/admin/panel/',
                SysLocale::t("Modules list") => '-',
            ],
        ];
    }

    public function actionIndex()
    {
        static::$title = SysLocale::t("Admin panel");
        $view = new SysView();

        $view->display('index');
    }

    public function actionModules()
    {
        static::$title = SysLocale::t("Modules list");

        $view = new SysView();
        $systemModules = SysModule::getAllModules('system');
		$appModules = SysModule::getAllModules('app');

        $view->systemModules = $systemModules;
        $view->appModules = $appModules;

        $view->display('modules');
    }

}