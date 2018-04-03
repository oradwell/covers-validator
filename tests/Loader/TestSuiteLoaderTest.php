<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Util\Configuration;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     */
    public function testLoadsSuite()
    {
        $configuration = Configuration::getInstance('tests/Fixtures/configuration-existing.xml');

        $returnedSuite = TestSuiteLoader::loadSuite($configuration);

        $this->assertInstanceOf(TestSuite::class, $returnedSuite);
        $this->assertEquals('My Test Suite', $returnedSuite->getName());
    }
}
