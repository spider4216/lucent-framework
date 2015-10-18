<?php

namespace core\tests\unit\modules\users\models;

use core\modules\users\models\Roles;

class RolesTest extends \PHPUnit_Framework_TestCase
{
    public function testIsRequiredName()
    {
        $roleName = '';
        $model = new Roles();

        $model->name = $roleName;

        $this->assertFalse($model->validate('name'));
    }
}
