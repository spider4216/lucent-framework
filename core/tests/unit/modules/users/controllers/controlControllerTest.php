<?php

namespace core\tests\unit\modules\users\controllers;

use core\classes\SysDatabase;
use core\classes\SysPassword;
use core\modules\users\models\Users;

class controlControllerTest extends \PHPUnit_Framework_TestCase
{
    protected $user;
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
        $this->user = new Users();
    }

    public function testCreate()
    {

        $this->user->username = 'test_user_name_999';
        $this->user->password = SysPassword::hash('test_password_123');
        $this->user->email = 'admin999@lucent.com';
        $this->user->role_id = '2';


        $result = $this->user->save();
        $id = $this->user->id;

        $this->assertTrue($result);

        return $id;
    }

    /**
     * @depends testCreate
     */
    public function testUpdate($id)
    {
        $user = $this->user->findByPk($id);

        $user->username = 'test_user_name_999';
        $user->password = SysPassword::hash('test_password_123');
        $user->email = 'admin8888@lucent.com';
        $user->role_id = '2';

        $this->assertTrue($user->save());
    }

    /**
     * @depends testCreate
     */
    public function testDelete($id)
    {
        $user = $this->user->findByPk($id);

        $this->assertTrue($user->delete());
    }
}
