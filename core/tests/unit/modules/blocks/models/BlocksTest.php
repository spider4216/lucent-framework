<?php

namespace core\tests\unit\modules\blocks\models;

use core\modules\blocks\models\Blocks;

class BlocksTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = new Blocks();
    }

    public function testIsRequiredName()
    {
        $blockName = '';

        $this->model->name = $blockName;
        $result = $this->model->validate('name');

        $this->assertFalse($result);
    }

    public function testIsRequiredContent()
    {
        $blockContent = '';

        $this->model->content = $blockContent;
        $result = $this->model->validate('content');

        $this->assertFalse($result);
    }

    public function testIsRequiredMachineName()
    {
        $blockMachineName = '';

        $this->model->machine_name = $blockMachineName;
        $result = $this->model->validate('machine_name');

        $this->assertFalse($result);
    }

    public function testIsMachineName()
    {
        $blockMachineName = 'machine_name';

        $this->model->machine_name = $blockMachineName;
        $result = $this->model->validate('machine_name');

        $this->assertTrue($result);
    }

}
