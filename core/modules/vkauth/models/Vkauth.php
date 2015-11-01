<?php
namespace core\modules\vkauth\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class Vkauth extends SysModel
{
    protected static $table = 'vkauth';

    protected static function labels()
    {
        return [
            'client_id' => SysLocale::t("Client ID"),
            'client_secret' => SysLocale::t("Client secret key"),
            'redirect_uri' => SysLocale::t("Redirect URL"),
        ];
    }
}