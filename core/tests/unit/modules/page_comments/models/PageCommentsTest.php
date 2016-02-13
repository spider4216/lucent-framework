<?php

namespace core\tests\unit\modules\page_comments\models;

use core\modules\page_comments\models\PageComments;

/**
 * @author farZa
 * Class PageCommentsTest
 * @package core\tests\unit\modules\page_comments\models
 */
class PageCommentsTest extends \PHPUnit_Framework_TestCase
{
    protected $pageComments;

    public function setUp()
    {
        $this->pageComments = new PageComments();
    }

    /**
     * #author farZa
     */
    public function testIsCommentRequired()
    {
        $comment = '';

        $this->pageComments;
        $this->pageComments->comment = $comment;
        $result = $this->pageComments->validate('comment');

        $this->assertFalse($result);
    }

    /**
     * @author farZa
     */
    public function testIsCommentUserIdNumeric()
    {
        $userId = 'string';

        $this->pageComments;
        $this->pageComments->user_id = $userId;
        $result = $this->pageComments->validate('user_id');

        $this->assertFalse($result);

        $userId = '1';

        $this->pageComments;
        $this->pageComments->user_id = $userId;
        $result = $this->pageComments->validate('user_id');

        $this->assertTrue($result);
    }

}
