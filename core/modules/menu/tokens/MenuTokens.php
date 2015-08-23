<?php
namespace core\modules\menu\tokens;

use core\classes\SysWidget;
use core\modules\menu\models\Menu;

class MenuTokens
{
    public function listAll()
    {
        $model = new Menu();

        $menuList = SysWidget::build('WTable', $model, [
            'columns' => [
                'name',
            ],

            'buttons' => [
                'update' => [
                    'link' => '/menu/general/update',
                ],
                'manage' => [
                    'link' => '/menu/general/manage',
                ],
                'delete' => [
                    'link' => '/menu/general/delete',
                ],
            ],
        ]);

        return $menuList;
    }
}