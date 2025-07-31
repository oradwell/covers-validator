<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

class OneTestWithProviderCoveringExistingClassTest extends TestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Tests\Fixtures\ExistingClass::existingMethod
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
