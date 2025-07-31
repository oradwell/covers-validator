<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

class OneTestWithProviderCoveringNonExistentClassTest extends TestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Tests\Fixtures\ExistingClass::nonExistingMethod
     *
     * @dataProvider provideDummyTest
     */
    public function testDummyTest($x)
    {
        $this->assertTrue(true);
    }

    public function provideDummyTest()
    {
        return [
            ['x'],
        ];
    }
}
