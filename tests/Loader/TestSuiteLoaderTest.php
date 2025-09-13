<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\ConfigLoader;
use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Model\TestCollection;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use PHPUnit\Runner\Version;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     * @covers \OckCyp\CoversValidator\Model\TestCollection
     */
    public function testLoadSuite()
    {
        $configurationHolder = ConfigLoader::loadConfig('tests/Fixtures/configuration-existing-2.xml');
        $testCollection = TestSuiteLoader::loadSuite($configurationHolder);

        $this->assertInstanceOf(TestCollection::class, $testCollection);

        foreach ($testCollection as $key => $test) {
            if ((int) Version::series() < 10) {
                $name = $test->getName();
            } else {
                $name = $test->name();
            }
            $this->assertEquals('testDummyTest', $name);

            return;
        }
    }
}
