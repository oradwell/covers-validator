<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Tests\BaseTestCase;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Loader\TestSuiteLoader::loadSuite
     */
    public function testLoadsSuite()
    {
        $testSuite = $this->getMockBuilder('PHPUnit_Framework_TestSuite')
            ->disableOriginalConstructor()
            ->getMock();

        $configuration = $this->getMockBuilder('PHPUnit_Util_Configuration')
            ->disableOriginalConstructor()
            ->setMethods(array('getTestSuiteConfiguration', 'handlePHPConfiguration'))
            ->getMock();

        $configuration->expects($this->once())
            ->method('getTestSuiteConfiguration')
            ->willReturn($testSuite);

        $returnedSuite = TestSuiteLoader::loadSuite($configuration);

        $this->assertEquals($testSuite, $returnedSuite);
    }
}
