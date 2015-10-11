<?php

namespace core\tests\unit\modules\page\models;

use core\modules\page\models\Page;

class PageTest extends \PHPUnit_Framework_TestCase
{
    protected $page;

    protected function setUp()
    {
        $this->page = new Page();
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
}
