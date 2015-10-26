<?php

namespace OckCyp\CoversValidator\Tests\Validator;

use OckCyp\CoversValidator\Tests\BaseTestCase;
use OckCyp\CoversValidator\Validator\Validator;

class ValidatorTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Validator\Validator::isValidMethod
     */
    public function testReturnsFalseForNonExistentClassBeingCovered()
    {
        $this->assertFalse(
            Validator::isValidMethod(
                $this->getFixtureClassName('OneTestCoveringNonExistentClassTest'),
                'testDummyTest'
            )
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Validator\Validator::isValidMethod
     */
    public function testReturnsTrueForExistingClassBeingCovered()
    {
        $this->assertTrue(
            Validator::isValidMethod(
                $this->getFixtureClassName('OneTestCoveringExistingClassTest'),
                'testDummyTest'
            )
        );
    }
}
