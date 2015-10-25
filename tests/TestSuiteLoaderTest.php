<?php

namespace OckCyp\CoversValidator\Tests;

use OckCyp\CoversValidator\TestSuiteLoader;

class TestSuiteLoaderTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\TestSuiteLoader::loadSuite
     */
    public function testLoadsSuite()
    {
        $testSuite = $this->getMockBuilder('PHPUnit_Framework_TestSuite')
            ->disableOriginalConstructor()
            ->getMock();

        $configuration = $this->getMockBuilder('PHPUnit_Util_Configuration')
            ->disableOriginalConstructor()
            ->setMethods(['getTestSuiteConfiguration', 'handlePHPConfiguration'])
            ->getMock();

        $configuration->expects($this->once())
            ->method('getTestSuiteConfiguration')
            ->willReturn($testSuite);

        $returnedSuite = TestSuiteLoader::loadSuite($configuration);

        $this->assertEquals($testSuite, $returnedSuite);
    }
}
