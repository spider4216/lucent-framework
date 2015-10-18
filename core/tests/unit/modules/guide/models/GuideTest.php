<?php

namespace core\tests\unit\modules\guide\models;

use core\modules\guide\models\Guide;

class GuideTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = new Guide();
    }

    public function testIsSwitchRequired()
    {
        $switch = '';

        $this->model->switch = $switch;
        $result = $this->model->validate('switch');

        $this->assertFalse($result);
    }

    public function testIsSwitchNumeric()
    {
        $switch = 'string';

        $this->model->switch = $switch;
        $result = $this->model->validate('switch');

        $this->assertFalse($result);
    }

    public function testIsMachineNameRequired()
    {
        $machineName = '';

        $this->model->machine_name = $machineName;
        $result = $this->model->validate('machine_name');

        $this->assertFalse($result);
    }

    public function testIsMachineName()
    {
        $machineName = 'not valid $%^';

        $this->model->machine_name = $machineName;
        $result = $this->model->validate('machine_name');

        $this->assertFalse($result);
    }


}
