<?php

namespace core\tests\functional;

class PageCollectionsTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $config;

    protected function setUp()
    {
        require_once __DIR__ . '/../TestConfig.php';

        $this->setBrowser('firefox');
        $this->setBrowserUrl(\TestConfig::DOMAIN_NAME);
    }

    public function testTitle()
    {
        $this->url(\TestConfig::DOMAIN_NAME);
        $btn = $this->byClassName('btn-primary')->text();
        $this->assertEquals('Read more', $btn);
    }
}
