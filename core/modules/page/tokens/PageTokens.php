<?php

namespace core\modules\page\tokens;


use core\classes\SysDisplay;
use core\classes\SysPath;
use core\classes\SysWidget;
use core\classes\SysController;
use core\modules\page\models\Page;

class PageTokens {

    public function listAll()
    {
        $model = new Page();

        $pagesList = SysWidget::build('WTable', $model, [
            'columns' => [
                'title',
            ],

            'buttons' => [
                'view' => [
                    'link' => '/page/basic/view',
                ],
                'update' => [
                    'link' => '/page/basic/update',
                ],
                'delete' => [
                    'link' => '/page/basic/delete',
                ],
            ],
        ]);

        return $pagesList;
    }
}