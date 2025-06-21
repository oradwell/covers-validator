<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

class TwoTestCoveringNonExistentClassTest extends TestCase
{
    /**
     * @covers \NonExistentClass
     */
    public function testDummyTest()
    {
        $this->assertTrue(true);
    }
}
