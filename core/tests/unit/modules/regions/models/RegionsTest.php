<?php

namespace core\tests\unit\modules\regions\models;

use core\modules\regions\models\Regions;

class RegionsTest extends \PHPUnit_Framework_TestCase
{
    protected $regions;

    public function setUp()
    {
        $this->regions = new Regions();
    }

    public function testIsNameRequiredForCreate()
    {
        $name = '';

        $this->regions->setScript('create');
        $this->regions->name = $name;
        $result = $this->regions->validate('name');

        $this->assertFalse($result);
    }

    public function testIsNameRequiredForUpdate()
    {
        $name = '';

        $this->regions->setScript('update');
        $this->regions->name = $name;
        $result = $this->regions->validate('name');

        $this->assertFalse($result);
    }


}
