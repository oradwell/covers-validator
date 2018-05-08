<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

class OneTestWithProviderCoveringNonExistentClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OckCyp\CoversValidator\Tests\Fixtures\ExistingClass::nonExistingMethod
     * @dataProvider provideDummyTest
     */
    public function testDummyTest($x)
    {

    }

    public function provideDummyTest()
    {
        return array(
            array('x'),
        );
    }
}
