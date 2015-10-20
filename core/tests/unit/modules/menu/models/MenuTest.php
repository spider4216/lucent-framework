<?php

namespace core\tests\unit\modules\menu\models;

use core\modules\menu\models\Menu;

class MenuTest extends \PHPUnit_Framework_TestCase
{
    protected $menu;

    public function setUp()
    {
        $this->menu = new Menu();
    }

    public function testIsNameRequiredForCreate()
    {
        $name = '';
        $this->menu->setScript('create');
        $this->menu->name = $name;

        $result = $this->menu->validate('name');

        $this->assertFalse($result);
    }

    public function testIsNameRequiredForUpdate()
    {
        $name = '';
        $this->menu->setScript('update');
        $this->menu->name = $name;

        $result = $this->menu->validate('name');

        $this->assertFalse($result);
    }

    public function testIsMachineNameValidForCreate()
    {
        $machineName = 'not valid machine name';
        $this->menu->setScript('create');
        $this->menu->machine_name = $machineName;

        $result = $this->menu->validate('machine_name');

        $this->assertFalse($result);
    }

    public function testIsMachineNameRequiredForCreate()
    {
        $machineName = '';
        $this->menu->setScript('create');
        $this->menu->machine_name = $machineName;

        $result = $this->menu->validate('machine_name');

        $this->assertFalse($result);
    }
}
