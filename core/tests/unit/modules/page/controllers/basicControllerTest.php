<?php

namespace core\tests\unit\modules\page\controllers;

use core\classes\SysDatabase;
use core\modules\page\models\Page;

class basicControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $page;
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
        $this->page = new Page();
    }

    public function testCreate()
    {
        $data = [
            'title' => 'title 1',
            'content' => 'content 1',
            'page_type_id' => '1',
            'allow_comments' => '1',
        ];

        $this->page->load($data);
        $result = $this->page->save();
        $id = $this->page->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $page = $this->page->findByPk($id);

        $data = [
            'title' => 'title 1 update',
            'content' => 'content 1 update',
            'page_type_id' => '1',
            'allow_comments' => '0',
        ];

        $page->load($data);

        $this->assertTrue($page->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $page = $this->page->findByPk($id);

        $this->assertTrue($page->delete());
    }
}
