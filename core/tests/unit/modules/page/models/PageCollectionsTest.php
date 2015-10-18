<?php

namespace core\tests\unit\modules\page\models;

use core\modules\page\models\PageCollections;

class PageCollectionsTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    public function setUp()
    {
        $this->model = new PageCollections();
    }

    public function testIsRequiredName()
    {
        $collectionName = '';

        $this->model->name = $collectionName;

        $this->assertFalse($this->model->validate('name'));
    }

    public function testIsRequiredPageTypeId()
    {
        $collectionTypeId = '';

        $this->model->page_type_id = $collectionTypeId;

        $this->assertFalse($this->model->validate('page_type_id'));
    }

    public function testIsIntPageTypeId()
    {
        $collectionTypeId = 'string';

        $this->model->page_type_id = $collectionTypeId;

        $this->assertFalse($this->model->validate('page_type_id'));
    }

    public function testIsRequiredRegionId()
    {
        $regionId = '';

        $this->model->region_id = $regionId;

        $this->assertFalse($this->model->validate('region_id'));
    }

    public function testIsIntRegionId()
    {
        $regionId = 'string';

        $this->model->region_id = $regionId;

        $this->assertFalse($this->model->validate('region_id'));
    }
}
