<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

class OneTestCoveringExistingTwoClassTest extends TestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Tests\Fixtures\ExistingClass::existingMethod
     */
    public function testDummyTest()
    {
        $this->assertTrue(true);
    }
}
