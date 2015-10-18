<?php

namespace core\tests\unit\modules\page\models;

use core\modules\page\models\PageType;

class PageTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = new PageType();
    }

    public function testIsRequiredName()
    {
        $typeName = '';

        $this->model->title = $typeName;

        $this->assertFalse($this->model->validate('title'));
    }
}
