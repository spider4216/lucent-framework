<?php

namespace core\modules\system\tokens;

use core\classes\SysDisplay;
use core\classes\SysMessages;

class SystemTokens {

    public function notifications()
    {
        $messages = SysMessages::pretty(SysMessages::getAll());

        $display = new SysDisplay();
        $display->messages = $messages;
        return $display->render('core/modules/system/tokens/templates/_system', true);
    }
}