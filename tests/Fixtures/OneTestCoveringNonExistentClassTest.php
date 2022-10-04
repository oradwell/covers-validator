<?php

namespace OckCyp\CoversValidator\Tests\Fixtures;

use PHPUnit\Framework\TestCase;

class OneTestCoveringNonExistentClassTest extends TestCase
{
    /**
     * @covers \NonExistentClass
     */
    public function testDummyTest()
    {
    }
}
