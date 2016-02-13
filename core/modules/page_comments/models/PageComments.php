<?php

namespace core\modules\page_comments\models;

use core\classes\SysLocale;
use core\classes\SysModel;

/**
 * @author farZa
 * Class PageComments
 * @package core\modules\page_comments\models
 */
class PageComments extends SysModel
{
    protected static $table = 'page_comments';

    protected static function labels()
    {
        return [
            'comment' => SysLocale::t("Comment"),
            'add_comments' => SysLocale::t("Add comment"),
        ];
    }

    public static function rules()
    {
        return [
            ['comment' => ['required']],
            ['page_id' => ['required', 'numeric']],
            ['user_id' => ['required', 'numeric']],
        ];
    }
}