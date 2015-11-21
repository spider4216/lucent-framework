<?php

namespace core\tests\unit\modules\page\controllers;


use core\classes\SysDatabase;
use core\modules\page\models\PageType;

class typeControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $pageType;
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
        $this->pageType = new PageType();
    }

    public function testCreate()
    {
        $data = [
            'title' => 'title 1',
            'description' => 'description 1',
        ];

        $this->pageType->load($data);
        $result = $this->pageType->save();
        $id = $this->pageType->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $pageType = $this->pageType->findByPk($id);

        $data = [
            'title' => 'title 1 update',
            'description' => 'description 1 update',
        ];

        $pageType->load($data);

        $this->assertTrue($pageType->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $pageType = $this->pageType->findByPk($id);

        $this->assertTrue($pageType->delete());
    }
}
