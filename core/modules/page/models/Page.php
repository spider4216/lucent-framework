<?php
namespace core\modules\page\models;

use core\classes\SysModel;

class Page extends SysModel
{
    protected static $table = 'pages';

    protected static function labels()
    {
        return [
            'title' => _("Title"),
            'content' => _("Content"),
        ];
    }

    public static function rules()
    {
        return [
            ['title' => ['required']],
            ['content' => ['required']],
        ];
    }

}