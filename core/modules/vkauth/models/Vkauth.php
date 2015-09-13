<?php
namespace core\modules\vkauth\models;

use core\classes\SysModel;

class Vkauth extends SysModel
{
    protected static $table = 'vkauth';

    protected static function labels()
    {
        return [
            'client_id' => _("Client ID"),
            'client_secret' => _("Client secret key"),
            'redirect_uri' => _("Redirect URL"),
        ];
    }
}