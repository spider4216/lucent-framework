<?php

namespace core\modules\system\tokens;

use core\classes\SysController;
use core\classes\SysDisplay;
use core\classes\SysMessages;
use core\classes\SysPath;

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
        $config = include SysPath::directory('app') . '/config/main.php';

        $controller = new SysController();
        $suffix = $controller::$title;
        return $config['project_name'] . ' | ' . $suffix;
    }
}