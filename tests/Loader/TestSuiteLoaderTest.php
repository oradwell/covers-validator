<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Model\TestCollection;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use PHPUnit\TextUI\Configuration\Configuration as PHPUnit9Configuration;
use PHPUnit\TextUI\Configuration\Loader as PHPUnit9ConfigurationLoader;
use PHPUnit\Util\Configuration as PHPUnit8Configuration;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     */
    public function testLoadsSuitePHPUnit8()
    {
        if (!class_exists(PHPUnit8Configuration::class)) {
            $this->markTestSkipped('Only for PHPUnit 8 and below');
        }

        $configuration = PHPUnit8Configuration::getInstance('tests/Fixtures/configuration-existing-2.xml');

        $configurationHolder = new ConfigurationHolder($configuration, '', '');

        $testCollection = TestSuiteLoader::loadSuite($configurationHolder);

        $this->assertInstanceOf(TestCollection::class, $testCollection);

        foreach ($testCollection as $test) {
            $this->assertEquals('testDummyTest', $test->getName());

            return;
        }
    }

    /**
     * @covers \OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     * @covers \OckCyp\CoversValidator\Model\TestCollection
     */
    public function testLoadsSuitePHPUnit9()
    {
        if (!class_exists(PHPUnit9Configuration::class)) {
            $this->markTestSkipped('Only for PHPUnit 9 and above');
        }

        $loader = new PHPUnit9ConfigurationLoader();

        $configuration = $loader->load('tests/Fixtures/configuration-existing-2.xml');

        $configurationHolder = new ConfigurationHolder($configuration, '', '');

        $testCollection = TestSuiteLoader::loadSuite($configurationHolder);

        $this->assertInstanceOf(TestCollection::class, $testCollection);

        foreach ($testCollection as $key => $test) {
            $this->assertEquals('testDummyTest', $test->getName());

            return;
        }
    }
}
