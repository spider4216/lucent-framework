<?php

namespace core\tests\unit\modules\blocks\controllers;

use core\classes\SysDatabase;
use core\modules\blocks\models\Blocks;

class generalControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $block;
    private $id;

    public static function setUpBeforeClass()
    {
        SysDatabase::getObj()->useDbTestsConnection();
    }

    public static function tearDownAfterClass()
    {
        SysDatabase::getObj()->resetDb();
    }

    protected function setUp()
    {
        $this->block = new Blocks();
    }

    public function testCreate()
    {
        $data = [
            'machine_name' => 'machine_name',
            'name' => 'Block name',
            'region_id' => '1',
            'content' => 'Block content',
            'weight' => '1',
        ];

        $this->block->load($data);
        $result = $this->block->save();
        $id = $this->block->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $block = $this->block->findByPk($id);

        $data = [
            'name' => 'Block name 2',
            'region_id' => '2',
            'content' => 'Block content 2',
            'weight' => '2',
        ];

        $block->load($data);

        $this->assertTrue($block->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $block = $this->block->findByPk($id);

        $this->assertTrue($block->delete());
    }
}
