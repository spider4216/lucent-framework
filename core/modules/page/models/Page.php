<?php
namespace core\modules\page\models;

use core\classes\SysLocale;
use core\classes\SysModel;

class Page extends SysModel
{
    protected static $table = 'pages';

    protected static function labels()
    {
        return [
            'title' => SysLocale::t("Title"),
            'content' => SysLocale::t("Content"),
            'page_type_id' => SysLocale::t("Type"),
            'allow_comments' => SysLocale::t("Allow comments"),
        ];
    }

    public static function rules()
    {
        return [
            ['title' => ['required']],
            ['content' => ['required']],
            ['page_type_id' => ['required', 'numeric']],
            ['allow_comments' => ['required', 'numeric']],
        ];
    }

}