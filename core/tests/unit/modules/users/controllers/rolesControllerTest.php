<?php

namespace core\tests\unit\modules\users\controllers;

use core\classes\SysDatabase;
use core\modules\users\models\Roles;

class rolesControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $roles;
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
        $this->roles = new Roles();
    }

    public function testCreate()
    {
        $data = [
            'name' => 'superuser',
        ];

        $this->roles->load($data);
        $result = $this->roles->save();
        $id = $this->roles->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $roles = $this->roles->findByPk($id);

        $data = [
            'name' => 'root',
        ];

        $roles->load($data);

        $this->assertTrue($roles->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $roles = $this->roles->findByPk($id);

        $this->assertTrue($roles->delete());
    }
}
