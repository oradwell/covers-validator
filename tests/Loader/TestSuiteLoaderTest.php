<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use PHPUnit\Framework\TestSuite;
use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Model\TestCollection;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     */
    public function testLoadsSuitePHPUnit8()
    {
        if (!class_exists(\PHPUnit\Util\Configuration::class)) {
            $this->markTestSkipped('Only for PHPUnit 8 and below');
        }

        $configurationHolder = new ConfigurationHolder($config, '', '');

        $returnedSuite = TestSuiteLoader::loadSuite($configurationHolder);

        $this->assertInstanceOf(TestSuite::class, $returnedSuite);
        $this->assertEquals('My Test Suite', $returnedSuite->getName());
    }
}
