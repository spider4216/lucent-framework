<?php

namespace core\modules\system\tokens;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysPath;
use core\extensions\ExtBreadcrumbs;
use core\system\App;

class SystemTokens {

    public function notifications()
    {
        $messages = SysMessages::pretty(SysMessages::getAll());

        $display = new SysDisplay();
        $display->messages = $messages;
        return $display->render('core/modules/system/tokens/templates/_system', true);
    }

    public function headTitle()
    {
        //$config = include SysPath::directory('app') . '/config/main.php';
        $config = App::$config;

        $controller = new SysController();
        $suffix = $controller::$title;
        return $config['project_name'] . ' | ' . $suffix;
    }

    public function breadcrumbs()
    {
        $display = new SysDisplay();

        $currentControllerName = SysController::$currentName;
        $currentActionName = SysController::$currentActionName;

        $controller = new $currentControllerName();

        $breadcrumbs = ExtBreadcrumbs::getAll($controller, $currentActionName);

        $display->breadcrumbs = $breadcrumbs;
        return $display->render('core/modules/system/tokens/templates/_breadcrumbs', true);
    }

    public function title()
    {
        $display = new SysDisplay();
        $currentControllerName = SysController::$currentName;
        $controller = new $currentControllerName();


        $display->title = $controller::$title;
        return $display->render('core/modules/system/tokens/templates/_title', true);
    }
}