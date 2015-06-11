<?php

namespace core\modules\users\tokens;

use core\classes\SysAuth;
use core\modules\users\models\Roles;
use core\modules\users\models\Users;
use core\classes\SysWidget;

class UsersTokens {

    public function sked()
    {
        $model = new Users;
        return SysWidget::build('WTable', $model, [
            'columns' => [
                'username',
            ],

            'buttons' => [
                'view' => [
                    'link' => '/users/control/user',
                ],
                'update' => [
                    'link' => '/users/control/update',
                ],
                'delete' => [
                    'link' => '/users/control/delete',
                ],
            ],
        ]);
    }

    public function roles()
    {
        $model = new Roles();
        return SysWidget::build('WTable', $model, [
            'columns' => [
                'name',
            ],

            'buttons' => [
                'update' => [
                    'link' => '/users/roles/update',
                ],
                'delete' => [
                    'link' => '/users/roles/delete',
                ],
            ],
        ]);
    }

    public function currentUsername()
    {
        return SysAuth::getCurrentUser();
    }
}