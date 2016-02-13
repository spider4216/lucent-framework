<?php

namespace core\tests\unit\modules\page_comments\controllers;

use core\classes\SysDatabase;
use core\modules\page_comments\models\PageComments;

/**
 * @author farZa
 * Class generalControllerTest
 * @package core\tests\unit\modules\page_comments\controllers
 */
class generalControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $pageComments;
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
        $this->pageComments = new PageComments();
    }

    /**
     * @author farZa
     */
    public function testAdd()
    {
        $data = [
            'comment' => 'text of comment',
            'user_id' => '1',
            'page_id' => '1',
        ];

        $this->pageComments->load($data);
        $result = $this->pageComments->save();
        $id = $this->pageComments->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @author farZa
     * @depends testAdd
     */
    public function testDelete($id)
    {
        $pageComments = $this->pageComments->findByPk($id);

        $this->assertTrue($pageComments->delete());
    }
}
