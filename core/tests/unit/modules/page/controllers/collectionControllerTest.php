<?php

namespace core\tests\unit\modules\page\controllers;

use core\classes\SysDatabase;
use core\modules\page\models\PageCollections;

class collectionControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $pageCollection;
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
        $this->pageCollection = new PageCollections();
    }

    public function testCreate()
    {
        $data = [
            'name' => 'title 1',
            'description' => 'description 1',
            'region_id' => '1',
            'page_type_id' => '1',
            'links' => 'http://example.com',
            'pagination' => '1',
            'weight' => '1',
        ];

        $this->pageCollection->load($data);
        $result = $this->pageCollection->save();
        $id = $this->pageCollection->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $pageCollection = $this->pageCollection->findByPk($id);

        $data = [
            'name' => 'title 1 update',
            'description' => 'description 1 update',
            'region_id' => '2',
            'page_type_id' => '2',
            'links' => 'http://example2.com',
            'pagination' => '2',
            'weight' => '2',
        ];

        $pageCollection->load($data);

        $this->assertTrue($pageCollection->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $pageCollection = $this->pageCollection->findByPk($id);

        $this->assertTrue($pageCollection->delete());
    }
}
