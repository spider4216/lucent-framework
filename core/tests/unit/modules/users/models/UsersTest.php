<?php

namespace core\tests\unit\modules\users\models;

use core\classes\SysPassword;
use core\modules\users\models\Users;

class UsersTest extends \PHPUnit_Framework_TestCase
{
    protected $user;

    protected function setUp()
    {
        $this->user = new Users();
    }

    public function testUsernameIsRequiredForUpdate()
    {
        $username = '';
        $this->user->setScript('update');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }

    public function testUsernameValidForUpdate()
    {
        $username = '123';
        $this->user->setScript('update');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }

    public function testUsernameIsRequiredForCreate()
    {
        $username = '';
        $this->user->setScript('create');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }

    public function testUsernameValidForCreate()
    {
        $username = '123';
        $this->user->setScript('create');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }

    public function  testEmailIsValidForUpdate()
    {
        $email = time();
        $this->user->setScript('update');

        $this->user->email = $email;

        $result = $this->user->validate('email');

        $this->assertFalse($result);
    }

    public function  testEmailIsValidForCreate()
    {
        $email = time();
        $this->user->setScript('create');

        $this->user->email = $email;

        $result = $this->user->validate('email');

        $this->assertFalse($result);
    }

    public function testPasswordCompareForCreate()
    {
        $password = 'admin';
        $passwordAgain = 'admin';

        $difference = SysPassword::hash($password) == SysPassword::hash($passwordAgain);

        $this->assertTrue($difference);
    }

    public function testUsernameIsRequiredForVkAuth()
    {
        $username = '';
        $this->user->setScript('vkAuth');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }

    public function testUsernameValidForVkAuth()
    {
        $username = '123';
        $this->user->setScript('vkAuth');

        $this->user->username = $username;

        $result = $this->user->validate('username');

        $this->assertFalse($result);
    }
}
