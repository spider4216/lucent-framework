<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 18.10.2015
 * Time: 14:02
 */

namespace core\tests\unit\modules\page\controllers;

use core\modules\page\models\Page;

class basicControllerTest extends \PHPUnit_Framework_TestCase
{

    public function testUpdateIsIdInt()
    {
        $id = 'string';
        $type = gettype((int)$id);

        $result = $type == 'integer' ? true : false;

        $this->assertTrue($result);
    }
}
