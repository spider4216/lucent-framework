<?php

namespace core\tests\unit\modules\page\models;

use core\classes\SysDatabase;
use core\modules\page\models\Page;

class PageTest extends \PHPUnit_Framework_TestCase
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
        $this->page->setScript(false);
    }

    public function testTitleValid()
    {
        $title = '';

        $this->page->title = $title;
        $this->assertFalse($this->page->validate('title'));
    }

    public function testContentValid()
    {
        $content = '';

        $this->page->content = $content;
        $this->assertFalse($this->page->validate('content'));
    }

    public function testPageTypeIdValid()
    {
        $pageTypeId = 1;

        $this->page->page_type_id = $pageTypeId;
        $this->assertTrue($this->page->validate('page_type_id'));
    }

    public function testCreate()
    {
        $data = [
            'title' => 'title 1',
            'content' => 'content 1',
            'page_type_id' => '1',
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
