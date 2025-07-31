<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

class OneTestCoveringNonExistentClassTest extends TestCase
{
    /**
     * @covers \NonExistentClass
     */
    public function testDummyTest()
    {
        $this->assertTrue(true);
    }
}
