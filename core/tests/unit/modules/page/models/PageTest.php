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
        $title = '123';

        $this->page->title = $title;
        $this->assertFalse($this->page->validate('title'));
    }
}
