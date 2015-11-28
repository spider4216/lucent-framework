<?php

namespace core\tests\unit\modules\regions\controllers;

use core\classes\SysDatabase;
use core\modules\regions\models\Regions;

class generalControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $regions;
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
        $this->regions = new Regions();
    }

    public function testCreate()
    {
        $data = [
            'name' => 'Region name',
        ];

        $this->regions->load($data);
        $result = $this->regions->save();
        $id = $this->regions->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $regions = $this->regions->findByPk($id);

        $data = [
            'name' => 'Region name 2',
        ];

        $regions->load($data);

        $this->assertTrue($regions->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $regions = $this->regions->findByPk($id);

        $this->assertTrue($regions->delete());
    }
}
