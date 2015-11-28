<?php

namespace core\tests\unit\modules\menu\controllers;


use core\classes\SysDatabase;
use core\modules\menu\models\Menu;

class generalControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $menu;
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
        $this->menu = new Menu();
    }

    public function testCreate()
    {
        $this->menu->setScript('create');

        $data = [
            'name' => 'Menu name',
            'machine_name' => 'machine_name',
            'description' => 'Menu description',
            'weight' => '1',
            'region_id' => '1',
        ];

        $this->menu->load($data);
        $result = $this->menu->save();
        $id = $this->menu->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $menu = $this->menu->findByPk($id);
        $menu->setScript('update');

        $data = [
            'name' => 'Menu name 2',
            'description' => 'Menu description 2',
            'weight' => '2',
            'region_id' => '2',
        ];

        $menu->load($data);

        $this->assertTrue($menu->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $menu = $this->menu->findByPk($id);

        $this->assertTrue($menu->delete());
    }
}
