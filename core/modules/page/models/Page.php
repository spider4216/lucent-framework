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
            'page_type_id' => _("Type"),
        ];
    }

    public static function rules()
    {
        return [
            ['title' => ['required']],
            ['content' => ['required']],
            ['page_type_id' => ['required', 'numeric']],
        ];
    }

}