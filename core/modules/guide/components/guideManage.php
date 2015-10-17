<?php

namespace core\modules\guide\components;

use core\classes\SysDisplay;
use core\classes\SysPath;

class guideManage
{
    public static function showModal()
    {
        $display = new SysDisplay();
        $modal = $display->render('core/modules/guide/views/general/slider', true);

        echo $modal;
    }
}